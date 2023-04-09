<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class ReligionFilter extends Filter
{

    function handle(Builder $query): void
    {
        $query->where('religion', $this->value);
    }
}
