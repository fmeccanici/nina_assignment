<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly int|string $value)
    {}

    abstract function handle(Builder $query): void;
}
