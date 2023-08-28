<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Enums\StatusEnums;
use App\Domains\User\Repository\ChatRepositoryInterface;
use Lucid\Units\Job;

class ChangeStatusJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId,
        private readonly StatusEnums $status
    ) {}

    public function handle(ChatRepositoryInterface $chatRepository): void
    {
        $chatRepository->changeStatus(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId,
            status: $this->status
        );
    }
}
