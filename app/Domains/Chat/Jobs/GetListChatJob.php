<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetListChatJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(UserRepositoryInterface $userRepository): Collection
    {
        return $userRepository->getListUserHasConversation(userId: $this->userId);
    }
}
