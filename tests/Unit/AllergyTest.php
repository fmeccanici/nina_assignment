<?php

use App\Models\Allergy;

it('should have a name', function (string $name) {
    $allergy = Allergy::factory()->create([
        'name' => $name
    ]);

    expect($allergy->name)->toBe($name);
})->with([
    'gluten', 'fish', 'eggs'
]);
