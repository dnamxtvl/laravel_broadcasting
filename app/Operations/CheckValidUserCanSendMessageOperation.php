<?php

namespace App\Operations;

use App\Domains\User\Jobs\CheckIsBlockedJob;
use Lucid\Units\Operation;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Domains\User\Jobs\FindUserJob;

class CheckValidUserCanSendMessageOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(): void
    {
        $user = $this->run(new FindUserJob(userId: $this->toUserId));
        if (is_null($user)) {
            throw new NotFoundHttpException('Không tồn tại user!');
        }

        $checkIsBlocked = $this->run(new CheckIsBlockedJob(toUserId: $this->toUserId));
        if (! $checkIsBlocked) {
            throw new AccessDeniedHttpException('Bạn và họ đã block nhau từ trước!');
        }
    }
}
