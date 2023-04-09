<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AllergiesFilter extends Filter
{

    function handle(Builder $query, \Closure $next): Builder
    {
        $query->whereRelation('allergies', 'name', $this->value);
        return $next($query);
    }
}
