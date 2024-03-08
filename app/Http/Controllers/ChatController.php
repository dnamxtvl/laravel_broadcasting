<?php

namespace App\Http\Controllers;

use App\Enums\Conversation\TypeEnum;
use App\Models\User;
use App\Repository\Interface\UserRepositoryInterface;
use App\Services\Interface\ChatServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatServiceInterface $chatService,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function listConversation(Request $request): View
    {
        $listConversations = User::query()->orderByDesc('created_at')->get();
        $listUsers = $this->userRepository->getQuery()->orderByDesc('created_at')->get();

        return view('chat.index', compact( 'listUsers'));
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
                conversationOrUserId: $conversationId,
                page: $request->input('page', config('app.default_page')),
                type: TypeEnum::tryFrom($request->input('type'))
            );

            return $this->respondWithJson(content: $listMessage->toArray());
        } catch (Throwable $throwable) {
            return $this->respondWithJsonError(e: $throwable);
        }
    }

    public function createNewConversation(Request $request): JsonResponse|RedirectResponse
    {
        $request->merge(['users' => [...$request->input('users'), Auth::id()]]);
        try {
            $this->chatService->createNewConversation(
                userIds: $request->input('users'),
                name: $request->input('name'),
                type: TypeEnum::MULTIPLE
            );

            return redirect()->back()->with('success', 'Create Group Success!');
        } catch (Throwable $throwable) {
            return redirect()->back()->with('error', $throwable->getMessage());
        }
    }
}
