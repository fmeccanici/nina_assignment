<?php

use App\Models\Allergy;
use App\Models\Gender;
use App\Models\User;

it('should have a religion, age, address and gender', function (string $religion, string $address,
                                                                int $age, bool $gender) {
    $user = User::factory()->create([
        'religion' => $religion,
        'age' => $age,
        'address' => $address,
        'gender' => $gender
    ]);

    expect($user->religion)
        ->toBe($religion)
        ->and($user->age)->toBe($age)
        ->and($user->address)->toBe($address)
        ->and($user->gender)->toBe($gender);
})->with([
    ['christianity', 'John Doe Street 12', 32, Gender::MALE->value],
    ['islam', 'Abrahamweg 1', 11, Gender::FEMALE->value],
    ['hinduism', 'Rijksweg 13', 65, Gender::MALE->value]
]);

it('should have multiple allergies', function (int $amountOfAllergies) {
    $user = User::factory()->has(Allergy::factory($amountOfAllergies))->create();

    expect($user->allergies)->toHaveCount($amountOfAllergies);
})->with([
    10, 20, 100
]);
