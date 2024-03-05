<?php

namespace App\Repository\Implement;

use App\Pipeline\Global\NameFilter;
use App\Repository\Interface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $user
    ) {}

    public function getQuery(array $columnSelects = [], array $filters = []): Builder
    {
        $query = $this->user->query();
        if (count($columnSelects)) {
            $query->select(columns:  $columnSelects);
        }

        return app(Pipeline::class)
            ->send($query)
            ->through([
                new NameFilter(filters: $filters),
            ])
            ->thenReturn();
    }

    public function getListUserDoesNotHaveConversation(string $userId): Builder
    {
        return $this->user->query()
            ->whereDoesntHave('conversations', function ($query) use ($userId) {
                $query->where('type', config('conversations.type.single'))
                    ->whereHas('users', function ($query) use ($userId) {
                        $query->where('users.id', $userId);
                    });
            });
    }

    public function findById(string $userId): ?Model
    {
        return $this->user->query()->find(id: $userId);
    }
}
