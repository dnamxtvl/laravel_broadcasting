<?php

namespace App\Domains\User\Jobs;

use Lucid\Units\Job;
use Illuminate\Support\Facades\Auth;

class CheckIsBlockedJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(): bool
    {
        $authUser = Auth::user();
        if ($authUser->can('isBlocked', $this->toUserId) ||
            $authUser->can('isBlockedAuth', $this->toUserId)
        ) {
            return false;
        }

        return true;
    }
}
