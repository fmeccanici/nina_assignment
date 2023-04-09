<?php

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
    [300, 30],
    [400, 99],
    [500, 77]
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
    [300, 'christianity'],
    [400, 'judaism'],
    [500, 'hinduism']
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
    [300, 'christianity', 30],
    [400, 'judaism', 99],
    [500, 'hinduism', 77]
]);

it('should filter on allergy', function (int $amountOfResultingUsers, string $allergy) {
    // Given
    $satisfyingAllergyUsers = User::factory($amountOfResultingUsers)
        ->hasAllergies(1, [
            'name' => $allergy
        ])
        ->create();

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
    [300, 'eggs'],
    [400, 'peanuts'],
    [500, 'fish']
]);
