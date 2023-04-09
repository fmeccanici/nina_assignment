<?php

use App\Enums\Gender;
use App\Models\Allergy;
use App\Models\User;

it('should have a religion, age, zipcode and gender', function (string $religion, string $zipcode,
                                                                int $age, bool $gender) {
    $user = User::factory()->create([
        'religion' => $religion,
        'age' => $age,
        'zipcode' => $zipcode,
        'gender' => $gender
    ]);

    expect($user->religion)
        ->toBe($religion)
        ->and($user->age)->toBe($age)
        ->and($user->zipcode)->toBe($zipcode)
        ->and($user->gender)->toBe($gender);
})->with([
    ['christianity', '7741DN', 32, Gender::MALE->value],
    ['islam', '7783BX', 11, Gender::FEMALE->value],
    ['hinduism', '7741GZ', 65, Gender::MALE->value]
]);

it('should have multiple allergies', function (int $amountOfAllergies) {
    $user = User::factory()->hasAttached(Allergy::factory($amountOfAllergies))->create();

    expect($user->allergies)->toHaveCount($amountOfAllergies);
})->with([
    10, 20, 100
]);
