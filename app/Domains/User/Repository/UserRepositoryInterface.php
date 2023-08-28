<?php

namespace App\Domains\User\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function getListUserHasConversation(int $userId): Collection;

    public function findById(int $id): Model|null;
}
