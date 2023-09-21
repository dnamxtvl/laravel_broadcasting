<?php

namespace App\Operations;

use App\Domains\Chat\Jobs\BlockUserJob;
use App\Domains\Chat\Jobs\DeleteMessageOfConversationJob;
use Lucid\Units\Operation;

class BlockUserAndDeleteMessageOfConversationOperation extends Operation
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
        $this->run(new BlockUserJob(fromUserId: $this->fromUserId, toUserId: $this->toUserId));
        $this->run(new DeleteMessageOfConversationJob(fromUserId: $this->fromUserId, toUserId: $this->toUserId));
    }
}
