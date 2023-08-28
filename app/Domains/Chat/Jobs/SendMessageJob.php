<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserRepositoryInterface;
use App\Events\SendMessageEvent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;

class SendMessageJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId,
        private readonly string $message,
    ) {}

    public function handle(): void
    {
        broadcast(new SendMessageEvent(Auth::user(), $this->toUserId, $this->message))->toOthers();
    }
}
