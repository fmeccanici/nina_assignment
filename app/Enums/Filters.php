<?php

namespace App\Enums;

use App\Filters\AllergiesFilter;
use App\Filters\BelowAgeFilter;
use App\Filters\Filter;
use App\Filters\ReligionFilter;

enum Filters: string
{
    case BELOW_AGE = 'belowAge';
    case RELIGION = 'religion';
    case ALLERGIES = 'users.allergies';

    public function create(int|string $value): Filter
    {
        return match($this) {
            self::BELOW_AGE => new BelowAgeFilter($value),
            self::RELIGION => new ReligionFilter($value),
            self::ALLERGIES => new AllergiesFilter($value),
        };
    }
}
