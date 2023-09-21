<?php

namespace App\Http\Controllers;

use App\Features\BlockUserFeature;
use App\Features\GetListChatsFeature;
use App\Features\GetListMessageDetailFeature;
use App\Features\SendMessageFeature;
use App\Features\UnBlockUserFeature;
use Illuminate\Http\JsonResponse;
use Lucid\Units\Controller;
use Illuminate\Contracts\View\View;

class ChatController extends Controller
{

    public function __construct()
    {}

    public function index(): View
    {
        return $this->serve(GetListChatsFeature::class);
    }

    public function sendUserMessage(): JsonResponse
    {
        return $this->serve(SendMessageFeature::class);
    }

    public function listDetailMessage($toUserId): JsonResponse
    {
        return $this->serve(GetListMessageDetailFeature::class, ['toUserId' => $toUserId]);
    }

    public function blockUser(): JsonResponse
    {
        return $this->serve(BlockUserFeature::class);
    }

    public function unBlockUser(): JsonResponse
    {
       return $this->serve(UnBlockUserFeature::class);
    }
}
