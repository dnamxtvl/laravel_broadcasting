<?php

namespace App\Http\Controllers;

use App\Features\GetListChatsFeature;
use App\Features\GetListMessageDetailFeature;
use App\Features\SendMessageFeature;
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
}
