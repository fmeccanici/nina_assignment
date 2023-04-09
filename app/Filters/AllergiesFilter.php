<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AllergiesFilter extends Filter
{

    function handle(Builder $query, \Closure $next): Builder
    {
        foreach (explode(',', $this->value) as $allergy)
        {
            $query->whereHas('allergies', function (Builder $query) use ($allergy) {
                $query->where('name', $allergy);
            });
        }

        return $next($query);
    }
}
