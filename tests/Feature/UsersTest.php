<?php

use App\Enums\Gender;
use App\Models\Allergy;
use App\Models\User;
use function Pest\Laravel\getJson;

beforeEach(function (){
    $this->withoutExceptionHandling();
});

it('should return all users', function (int $amountOfUsers) {
    // Given
    $users = User::factory($amountOfUsers)->create();

    // When
    getJson(route('users.index'))

    // Then
    ->assertExactJson([
        'data' => $users->toArray()
    ]);
})->with([
    10,
    20,
    100
]);

it('should filter on age', function (int $amountOfUsersBelowAgeLimit, int $ageLimit) {
    // Given
    $usersBelowAgeLimit = User::factory($amountOfUsersBelowAgeLimit)->create([
        'age' => rand(1, $ageLimit - 1)
    ]);

    $usersAboveAgeLimit = User::factory(100)->create([
        'age' => rand($ageLimit, 120)
    ]);

    // When
    getJson(route('users.index', [
        'filter[belowAge]' => $ageLimit
    ]))

    // Then
    ->assertJsonCount($usersBelowAgeLimit->count(), 'data')
    ->assertExactJson([
        'data' => $usersBelowAgeLimit->toArray()
    ]);
})->with([
    [30, 30],
    [40, 99],
    [50, 77]
]);

it('should filter on religion', function (int $amountOfReligiousUsers, string $religion) {
    // Given
    $religiousUsers = User::factory($amountOfReligiousUsers)->create([
        'religion' => $religion
    ]);

    $atheistUsers = User::factory(100)->create([
        'religion' => 'atheist',
    ]);

    // When
    getJson(route('users.index', [
        'filter[religion]' => $religion
    ]))

        // Then
        ->assertJsonCount($religiousUsers->count(), 'data')
        ->assertExactJson([
            'data' => $religiousUsers->toArray()
        ]);
})->with([
    [30, 'christianity'],
    [40, 'judaism'],
    [50, 'hinduism']
]);

it('should filter on age and religion', function (int $amountOfResultingUsers, string $religion, int $ageLimit) {
    // Given
    $satisfyingAgeLimitAndReligionUsers = User::factory($amountOfResultingUsers)->create([
        'religion' => $religion,
        'age' => rand(1, $ageLimit - 1)
    ]);

    User::factory(100)->create([
        'religion' => 'atheist',
        'age' => rand($ageLimit, 120)
    ]);

    $satisfyingAgeLimitUsers = User::factory(100)->create([
        'religion' => 'atheist',
        'age' => rand(1, $ageLimit - 1)
    ]);

    $satisfyingReligionUsers = User::factory(100)->create([
        'religion' => $religion,
        'age' => rand($ageLimit, 120)
    ]);

    // When
    getJson(route('users.index', [
        'filter[religion]' => $religion,
        'filter[belowAge]' => $ageLimit
    ]))

        // Then
        ->assertJsonCount($satisfyingAgeLimitAndReligionUsers
            ->count(), 'data')
        ->assertExactJson([
            'data' => $satisfyingAgeLimitAndReligionUsers->toArray()
        ]);
})->with([
    [30, 'christianity', 30],
    [40, 'judaism', 99],
    [50, 'hinduism', 77]
]);

it('should filter on allergy', function (int $amountOfResultingUsers, string $allergy) {
    // Given
    $satisfyingAllergyUsers = User::factory($amountOfResultingUsers)
        ->create()
        ->each(function (User $user) use ($allergy) {
            $allergy = Allergy::factory()->create([
                'name' => $allergy
            ]);
            $user->allergies()->attach($allergy);
        });

    User::factory(100)->create();

    // When
    getJson(route('users.index', [
        'filter[users.allergies]' => $allergy,
    ]))
        // Then
        ->assertJsonCount($satisfyingAllergyUsers
            ->count(), 'data')
        ->assertExactJson([
            'data' => $satisfyingAllergyUsers->toArray()
        ]);
})->with([
    [30, 'eggs'],
    [40, 'peanuts'],
    [50, 'fish']
]);

it('should filter on allergies', function (int $amountOfResultingUsers, array $allergies) {
    // Given
    $satisfyingAllergyUsers = User::factory($amountOfResultingUsers)
        ->create()
        ->each(function (User $user) use ($allergies) {
            collect($allergies)->each(function (string $allergy) use ($user) {
                $allergy = Allergy::factory()->create([
                    'name' => $allergy
                ]);
                $user->allergies()->attach($allergy);
            });
        });

    User::factory(100)->create();

    // When
    getJson(route('users.index', [
        'filter[users.allergies]' => implode(',', $allergies),
    ]))
        // Then
        ->assertJsonCount($satisfyingAllergyUsers
            ->count(), 'data')
        ->assertExactJson([
            'data' => $satisfyingAllergyUsers->toArray()
        ]);
})->with([
    [30, ['eggs', 'tomato', 'walnuts']],
    [40, ['peanuts', 'grass', 'milk']],
    [50, ['fish', 'cheese', 'gluten']]
]);

it('should filter on gender', function (int $amountOfUsers, bool $gender) {
    // Given
    $resultingUsers = User::factory($amountOfUsers)->create([
        'gender' => $gender
    ]);

    $otherUsers = User::factory(100)->create([
        'gender' => ! $gender,
    ]);

    // When
    getJson(route('users.index', [
        'filter[gender]' => $gender
    ]))

        // Then
        ->assertJsonCount($resultingUsers->count(), 'data')
        ->assertExactJson([
            'data' => $resultingUsers->toArray()
        ]);
})->with([
    [30, Gender::MALE->value],
    [40, Gender::FEMALE->value],
    [50, Gender::FEMALE->value],
]);

it('should filter on zipcode', function (int $amountOfUsers, string $zipcode) {
    // Given
    $resultingUsers = User::factory($amountOfUsers)->create([
        'zipcode' => $zipcode
    ]);

    $otherUsers = User::factory(100)->create();

    // When
    getJson(route('users.index', [
        'filter[zipcode]' => $zipcode
    ]))

        // Then
        ->assertJsonCount($resultingUsers->count(), 'data')
        ->assertExactJson([
            'data' => $resultingUsers->toArray()
        ]);
})->with([
    [30, '3023AB'],
    [40, '2020CD'],
    [50, '2480PB'],
]);
