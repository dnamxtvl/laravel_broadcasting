<?php

namespace App\Data\Repository;

use App\Domains\User\Repository\UserBlockRepositoryInterface;
use App\Data\Models\UserBlock;
use Illuminate\Database\Eloquent\Model;

class UserBlockRepository implements UserBlockRepositoryInterface
{
    public function __construct(
        private readonly UserBlock $userBlock
    ) {}

    public function findByUserIdAndBlockUserId(int $userId, int $blockUserId): null|Model
    {
        return $this->userBlock->query()
            ->where('user_id', $userId)
            ->where('block_user_id', $blockUserId)
            ->first();
    }
}
