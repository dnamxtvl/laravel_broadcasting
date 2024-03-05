<?php

namespace App\Pipeline\Global;

use Illuminate\Database\Eloquent\Builder;

class NameFilter
{
    public function __construct(
        private readonly array $filters,
    ) {
    }

    public function handle(Builder $query, $next)
    {
        if (isset($this->filters['name'])) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }

        return $next($query);
    }
}
