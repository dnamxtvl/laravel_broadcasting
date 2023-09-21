<?php

namespace App\Features;

use App\Domains\Chat\Enums\ExceptionCode;
use App\Domains\Chat\Requests\BlockUserRequest;
use App\Domains\User\Jobs\CheckIsBlockedJob;
use App\Domains\User\Jobs\FindUserJob;
use App\Operations\UnBlockUserAndRestoreMessageOfConversationOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnBlockUserFeature extends Feature
{
    public function __construct(
    ) {
    }

    public function handle(BlockUserRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            $toUserId = $request->input('to_user_id');
            $user = $this->run(new FindUserJob(userId: $toUserId));
            if (is_null($user)) {
                throw new NotFoundHttpException('Không tồn tại user!');
            }

            $checkIsBlocked = $this->run(new CheckIsBlockedJob(toUserId: $toUserId));
            if ($checkIsBlocked) {
                throw new AccessDeniedHttpException('User chưa hề bị chăn!');
            }

            $this->run(new UnBlockUserAndRestoreMessageOfConversationOperation(fromUserId: $fromUserId, toUserId: $toUserId));

            DB::commit();
            return $this->run(new RespondWithJsonJob(content: [], status: Response::HTTP_OK));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->run(new RespondWithJsonErrorJob(
                message: $exception->getMessage(),
                code: ExceptionCode::BLOCK_USER_FAIL->value,
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        }
    }
}
