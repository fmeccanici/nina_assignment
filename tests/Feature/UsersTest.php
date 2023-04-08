<?php

use App\Models\User;

it('should return all users', function (int $amountOfUsers) {
    // Given
    $users = User::factory($amountOfUsers)->create();

    // When
    $response = $this->get(route('users.index'));

    // Then
    $response->assertJson([
        'data' => $users->toJson()
    ]);
})->with([
    10,
    20,
    100
]);
