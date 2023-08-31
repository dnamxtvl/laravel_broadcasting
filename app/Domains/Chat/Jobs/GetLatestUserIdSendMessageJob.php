<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;
use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetLatestUserIdSendMessageJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(ChatRepositoryInterface $chatRepository): int
    {
        $latestToUser = $chatRepository->latestToUser(userId: $this->userId);

        return $latestToUser ? $latestToUser->to_user_id : $this->userId;
    }
}
