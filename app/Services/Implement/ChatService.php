<?php

namespace App\Services\Implement;

use App\Enums\Conversation\TypeEnum;
use App\Events\SaveMessageEvent;
use App\Events\SendMessageEvent;
use App\Models\Conversation;
use App\Models\User;
use App\Models\UserConversation;
use App\Repository\Interface\ConversationRepositoryInterface;
use App\Repository\Interface\MessageRepositoryInterface;
use App\Repository\Interface\UserRepositoryInterface;
use App\Services\Interface\ChatServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChatService implements ChatServiceInterface
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly MessageRepositoryInterface $messageRepository
    ) {}
    public function getListConversations(string $userId, int $page): Collection
    {
        $listConversations = $this->conversationRepository->getListConversations(userId: $userId)
            ->limit(config('app.default_page_limit_row'))
            ->offset(($page - config('app.default_page')) * config('app.default_page_limit_row'))
            ->get()->map(function ($conversation) {
                return [
                    'id' => $conversation->id,
                    'name' => $conversation->name,
                    'avatar_url' => $conversation->users->pluck('avatar_url')->toArray(),
                    'count_unread' => $conversation->userConversations->first()->no_unread_message,
                    'latest_message' => $conversation->latestMessage ? [
                        'content' => $conversation->latestMessage->content,
                        'type' => $conversation->latestMessage->type,
                    ] : null,
                    'latest_online_at' => $conversation->latest_online_at
                ];
        })->sortBy('latest_online_at');

        $listUserDoesNotHaveConversation = $this->userRepository->getListUserDoesNotHaveConversation(userId: $userId)
            ->limit(config('app.default_page_limit_row'))
            ->offset(($page - config('app.default_page')) * config('app.default_page_limit_row'))
            ->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar_url' => $user->avatar_url,
                'count_unread' => config('app.default_count_unread'),
                'type' => config('conversations.type.does_not_have'),
                'latest_message' => null,
                'latest_online_at' => null
            ];
        })->sortBy('created_at');

        return $listConversations->count() ?
            $listConversations->merge(items: $listUserDoesNotHaveConversation) :
            $listUserDoesNotHaveConversation;
    }

    public function getMessageOfConversation(string $conversationId, int $page): Collection
    {
        $conversation = $this->conversationRepository->findById(conversationId: $conversationId);

        if (is_null($conversation)) {
            throw new NotFoundHttpException('Conversation not found');
        }

        /** @var UserConversation $conversation */
        $userConversations = $conversation->userConversations()->where('user_id', Auth::id())->first();
        if (! is_null($userConversations)) {
            $userConversations->no_unread_message = 0;
            $userConversations->save();
        }

        return $this->messageRepository->getMessageOfConversation(conversationId: $conversationId)
            ->limit(config('app.default_page_limit_row'))
            ->offset(($page - config('app.default_page')) * config('app.default_page_limit_row'))
            ->orderByDesc('created_at')
            ->get()
            ->reverse()
            ->values();
    }

    public function sendMessage(string $conversationOrUserId, string $message, TypeEnum $type): void
    {
        if ($type != TypeEnum::DOES_NOT_HAVE_CONVERSATION) {
            $conversation = $this->conversationRepository->findById(conversationId: $conversationOrUserId);
            if (is_null($conversation)) {
                throw new NotFoundHttpException(message: 'Conversation not found');
            }
            /*** @var Conversation $conversation **/
            $this->sendMessageRealtime(conversation: $conversation, message: $message, isFirstMessage: false);
        } else {
            $isFirstMessage = true;
            $userReceiveMessage = $this->userRepository->findById(userId: $conversationOrUserId);
            if (is_null($userReceiveMessage)) {
                throw new NotFoundHttpException(message: 'Người dùng này đã bị xóa!');
            }
            /*** @var User $userReceiveMessage **/
            $conversation = $userReceiveMessage->conversations()
                ->where('type', config('conversations.type.single'))
                ->whereHas('userConversations', function ($query) {
                    $query->where('user_id', Auth::id());
                })->first();

            if (! is_null($conversation)) {
                $isFirstMessage = false;
                $conversation = $this->createNewConversation(userId: $conversationOrUserId);
            }

            $this->sendMessageRealtime(conversation: $conversation, message: $message, isFirstMessage: $isFirstMessage);
        }
    }

    private function createNewConversation(string $userId): Conversation
    {

    }

    private function sendMessageRealtime(Conversation $conversation, string $message, bool $isFirstMessage): void
    {
        $users = $conversation->users;

        if (! in_array(Auth::id(), $users->pluck('id')->toArray())) {
            throw new HttpException(statusCode: Response::HTTP_FORBIDDEN, message: 'Bạn đã bị xóa khỏi nhóm!');
        }

        event(new SaveMessageEvent(conversationId: $conversation->id, message: $message));
        foreach ($users as $user) {
            broadcast(new SendMessageEvent(
                user: $user,
                conversationId: $conversation->id,
                isFirstMessage: $isFirstMessage,
                message: $message
            ))->toOthers();
        }
    }
}
