<?php

namespace App\Pipeline\Global;

use Illuminate\Database\Eloquent\Builder;

class ConversationIdFilter
{
    public function __construct(
        private readonly array $filters,
    ) {
    }

    public function handle(Builder $query, $next)
    {
        if (isset($this->filters['conversation_id'])) {
            $query->where('conversation_id', $this->filters['conversation_id']);
        }

        return $next($query);
    }
}
