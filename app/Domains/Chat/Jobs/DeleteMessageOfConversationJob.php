<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;
use App\Domains\User\Repository\UserBlockRepositoryInterface;
use Lucid\Units\Job;

class DeleteMessageOfConversationJob extends Job
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

    public function handle(ChatRepositoryInterface $chatRepository): void
    {
        $emptyConversation = $chatRepository->emptyConversation(fromUserId: $this->fromUserId, toUserId: $this->toUserId);
        if ($emptyConversation) {
            $chatRepository->deleteConversation(fromUserId: $this->fromUserId, toUserId: $this->toUserId);
        }
    }
}
