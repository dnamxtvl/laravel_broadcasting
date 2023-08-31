<?php

namespace App\Features;

use App\Domains\Chat\Enums\StatusEnums;
use App\Domains\Chat\Jobs\ChangeStatusJob;
use App\Domains\Chat\Jobs\GetDetailMessageJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Symfony\Component\HttpFoundation\Response;

class GetListMessageDetailFeature extends Feature
{
    private const DEFAULT_PAGE = 1;

    public function __construct(
        private readonly int $toUserId
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $limitRow = config('chat.limit_row_message');
        $page = $request->page ?? self::DEFAULT_PAGE;
        $offset = ($page - self::DEFAULT_PAGE) * $limitRow;

        $this->run(new ChangeStatusJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            status: StatusEnums::STATUS_READ
        ));

        $listMessage = $this->run(new GetDetailMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            limit: $limitRow,
            offset: $offset
        ));

        return $this->run(new RespondWithJsonJob($listMessage, Response::HTTP_OK));
    }
}
