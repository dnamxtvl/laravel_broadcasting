<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserBlockRepositoryInterface;
use Lucid\Units\Job;

class BlockUserJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId,
    ) {}

    public function handle(UserBlockRepositoryInterface $userBlockRepository): void
    {
        $userBlockRepository->blockUser(userId: $this->fromUserId, blockUserId: $this->toUserId);
    }
}
