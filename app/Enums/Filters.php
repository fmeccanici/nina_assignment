<?php

namespace App\Enums;

use App\Filters\AllergiesFilter;
use App\Filters\BelowAgeFilter;
use App\Filters\Filter;
use App\Filters\GenderFilter;
use App\Filters\MinAgeFilter;
use App\Filters\ReligionFilter;
use App\Filters\ZipcodeFilter;

enum Filters: string
{
    case BELOW_AGE = 'belowAge';
    case RELIGION = 'religion';
    case ALLERGIES = 'users.allergies';
    case GENDER = 'gender';
    case ZIPCODE = 'zipcode';
    case MIN_AGE = 'min_age';

    public function create(int|string|bool $value): Filter
    {
        return match($this) {
            self::BELOW_AGE => new BelowAgeFilter($value),
            self::RELIGION => new ReligionFilter($value),
            self::ALLERGIES => new AllergiesFilter($value),
            self::GENDER => new GenderFilter($value),
            self::ZIPCODE => new ZipcodeFilter($value),
            self::MIN_AGE => new MinAgeFilter($value),
        };
    }
}
