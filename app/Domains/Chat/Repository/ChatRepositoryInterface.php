<?php

namespace App\Domains\Chat\Repository;

use App\Domains\Chat\Enums\StatusEnums;
use Illuminate\Database\Eloquent\Collection;

interface ChatRepositoryInterface
{
    public function latestToUser(int $userId);

    public function changeStatus(int $fromUserId, int $toUserId, StatusEnums $status): void;

    public function getMessageDetail(int $fromUserId, int $toUserId, int $limit, int $offset): Collection;
}
