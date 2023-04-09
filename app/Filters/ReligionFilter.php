<?php

namespace App\Filters;


use Closure;
use Illuminate\Database\Eloquent\Builder;

class ReligionFilter extends Filter
{

    function handle(Builder $query, Closure $next): Builder
    {
        $query->where('religion', $this->value);
        return $next($query);
    }
}
