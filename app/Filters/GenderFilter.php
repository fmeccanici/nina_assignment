<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GenderFilter extends Filter
{

    function handle(Builder $query, \Closure $next): Builder
    {
        $query->where('gender', $this->value);
        return $next($query);
    }
}
