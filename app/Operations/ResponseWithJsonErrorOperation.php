<?php

namespace App\Operations;

use Exception;
use Illuminate\Support\Facades\Log;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Units\Operation;
use Symfony\Component\HttpFoundation\Response;

class ResponseWithJsonErrorOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Exception $e
    ) {}

    public function handle()
    {
        Log::error($this->e);

        return $this->run(new RespondWithJsonErrorJob(
            message: $this->e->getMessage(),
            code: $this->e->getCode(),
            status: method_exists($this->e, 'getStatusCode') ? $this->e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR
        ));
    }
}
