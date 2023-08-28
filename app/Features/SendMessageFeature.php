<?php

namespace App\Features;

use App\Domains\Chat\Enums\ExceptionCode;
use App\Domains\Chat\Jobs\SendMessageJob;
use App\Domains\Chat\Requests\SendMessageRequest;
use App\Operations\SendMessageOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Symfony\Component\HttpFoundation\Response;

class SendMessageFeature extends Feature
{
    public function __construct(
    ) {
    }

    public function handle(SendMessageRequest $request): JsonResponse
    {
        try {
            $this->run(new SendMessageOperation(
                toUserId: $request->input('to_user_id'),
                message: $request->input('message'))
            );

            return $this->run(new RespondWithJsonJob(
                content: [],
                status: Response::HTTP_OK
            ));
        } catch (Exception $exception) {
            return $this->run(new RespondWithJsonErrorJob(
                message: $exception->getMessage(),
                code: ExceptionCode::SEND_MESSAGE_FAIL->value,
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        }
    }
}
