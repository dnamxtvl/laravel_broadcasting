<?php

namespace App\Operations;

use App\Domains\Chat\Jobs\SendMessageJob;
use App\Domains\User\Repository\UserRepositoryInterface;
use Lucid\Units\Operation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SendMessageOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId,
        private readonly string $message
    ) {}

    public function handle(UserRepositoryInterface $userRepository): void
    {
        $user = $userRepository->findById(id: $this->toUserId);
        throw new NotFoundHttpException('Không tồn tại user');
        if (is_null($user)) {
            throw new NotFoundHttpException('Không tồn tại user');
        }

        $this->run(new SendMessageJob(toUserId: $this->toUserId,message: $this->message));
    }
}
