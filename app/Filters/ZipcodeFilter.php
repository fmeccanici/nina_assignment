<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ZipcodeFilter extends Filter
{

    function handle(Builder $query, \Closure $next): Builder
    {
        $query->where('zipcode', $this->value);
        return $next($query);
    }
}
