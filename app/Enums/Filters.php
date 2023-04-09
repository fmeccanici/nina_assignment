<?php

namespace App\Enums;

use App\Filters\BelowAgeFilter;
use App\Filters\Filter;

enum Filters: string
{
    case BELOW_AGE = 'belowAge';

    public function create(int $value): Filter
    {
        return match($this) {
            self::BELOW_AGE => new BelowAgeFilter($value)
        };
    }
}
