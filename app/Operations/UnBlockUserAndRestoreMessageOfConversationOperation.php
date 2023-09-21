<?php

namespace App\Operations;

use App\Domains\Chat\Jobs\RestoreMessageOfConversationJob;
use App\Domains\Chat\Jobs\UnBlockUserJob;
use Lucid\Units\Operation;

class UnBlockUserAndRestoreMessageOfConversationOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId
    ) {}

    public function handle(): void
    {
        $this->run(new UnBlockUserJob(fromUserId: $this->fromUserId, toUserId: $this->toUserId));
        $this->run(new RestoreMessageOfConversationJob(fromUserId: $this->fromUserId, toUserId: $this->toUserId));
    }
}
