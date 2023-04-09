<?php

use App\Models\User;
use function Pest\Laravel\getJson;

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
