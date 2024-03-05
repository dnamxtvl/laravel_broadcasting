<?php

namespace App\Http\Controllers;

use App\Enums\Conversation\TypeEnum;
use App\Events\SendMessageEvent;
use App\Services\Interface\ChatServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatServiceInterface $chatService
    ) {}

    public function listConversation(Request $request): View
    {
        $listConversations = $this->chatService->getListConversations(
            userId: Auth::id(),
            page: $request->input('page', config('app.default_page'))
        );

        return view('chat.index', compact('listConversations'));
    }

    public function sendMessage(Request $request): JsonResponse
    {
        try {
            $this->chatService->sendMessage(
                conversationOrUserId: $request->input('conversation_id'),
                message: $request->input('message'),
                type: TypeEnum::tryFrom($request->input('type'))
            );

            return $this->respondWithJson(content: []);
        } catch (Throwable $throwable) {
            return $this->respondWithJsonError(e: $throwable);
        }
    }

    public function getMessageOfConversation(string $conversationId, Request $request): JsonResponse
    {
        try {
            $listMessage = $this->chatService->getMessageOfConversation(
                conversationId: $conversationId,
                page: $request->input('page', config('app.default_page'))
            );

            return $this->respondWithJson(content: $listMessage->toArray());
        } catch (Throwable $throwable) {
            return $this->respondWithJsonError(e: $throwable);
        }
    }
}
