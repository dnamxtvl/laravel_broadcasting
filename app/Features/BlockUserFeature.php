<?php

namespace App\Features;

use App\Domains\Chat\Requests\BlockUserRequest;
use App\Operations\BlockUserAndDeleteMessageOfConversationOperation;
use App\Operations\CheckValidUserCanSendMessageOperation;
use App\Operations\ResponseWithJsonErrorOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Symfony\Component\HttpFoundation\Response;

class BlockUserFeature extends Feature
{
    public function __construct(
    ) {}

    public function handle(BlockUserRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            $toUserId = $request->input('to_user_id');
            $this->run(new CheckValidUserCanSendMessageOperation(toUserId: $toUserId));
            $this->run(new BlockUserAndDeleteMessageOfConversationOperation(fromUserId: $fromUserId, toUserId: $toUserId));

            DB::commit();
            return $this->run(new RespondWithJsonJob(content: [], status: Response::HTTP_OK));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->run(new ResponseWithJsonErrorOperation(e: $exception));
        }
    }
}
