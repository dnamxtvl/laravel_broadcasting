<?php

namespace App\Features;

use App\Domains\Chat\Jobs\SendMessageJob;
use App\Domains\Chat\Requests\SendMessageRequest;
use App\Operations\CheckValidUserCanSendMessageOperation;
use App\Operations\ResponseWithJsonErrorOperation;
use Exception;
use Illuminate\Http\JsonResponse;
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
        $toUserId = $request->input('to_user_id');

        try {
            $this->run(new CheckValidUserCanSendMessageOperation(toUserId: $toUserId));
            $this->run(new SendMessageJob(toUserId: $toUserId, message: $request->input('message')));

            return $this->run(new RespondWithJsonJob(content: [], status: Response::HTTP_OK));
        } catch (Exception $exception) {
            return $this->run(new ResponseWithJsonErrorOperation(e: $exception));
        }
    }
}
