<?php

namespace App\Repository\Interface;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function getQuery(array $columnSelects = [], array $filters = []): Builder;

    public function getListUserDoesNotHaveConversation(string $userId): Builder;

    public function findById(string $userId): ?Model;
}
