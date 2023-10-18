<?php

namespace App\Features;

use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Jobs\ChangeStatusOfMessageJob;
use App\Domains\Chat\Jobs\GetDetailMessageJob;
use App\Operations\CheckValidUserCanSendMessageOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Symfony\Component\HttpFoundation\Response;

class GetListMessageDetailFeature extends Feature
{
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $limitRow = config('chat.limit_row_message');
        $defaultPage = config('chat.default_page');
        $page = $request->page ?? $defaultPage;
        $offset = ($page - $defaultPage) * $limitRow;

        $this->run(new CheckValidUserCanSendMessageOperation(toUserId: $this->toUserId));

        $this->run(new ChangeStatusOfMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            status: StatusMessageEnums::STATUS_READ
        ));

        $listMessage = $this->run(new GetDetailMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            limit: $limitRow,
            offset: $offset
        ));

        return $this->run(new RespondWithJsonJob(content: $listMessage, status: Response::HTTP_OK));
    }
}
