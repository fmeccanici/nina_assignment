<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class MinAgeFilter extends Filter
{

    function handle(Builder $query, Closure $next): Builder
    {
        $query->where('age', '>=', $this->value);

        return $next($query);
    }
}
