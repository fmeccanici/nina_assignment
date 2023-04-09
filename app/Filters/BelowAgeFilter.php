<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class BelowAgeFilter extends Filter
{

    function handle(Builder $query): void
    {
        $query->where('age', '<', $this->value);
    }
}
