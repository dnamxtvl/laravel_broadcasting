<?php

namespace App\Domains\User\Jobs;

use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class FindUserJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(UserRepositoryInterface $userRepository): Model|null
    {
        return $userRepository->findById(id: $this->userId);
    }
}
