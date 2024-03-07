<?php

namespace App\Services\Implement;

use App\DTOs\SaveConversationDTO;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
                    'name' => !$conversation->type ?
                        ($conversation->created_by != Auth::id() ? $conversation->createdByUser->name : $conversation->name)
                        : $conversation->name,
                    'avatar_url' => $conversation->users->pluck('avatar_url')->first(),
                    'count_unread' => $conversation->userConversations->first()->no_unread_message,
                    'type' => $conversation->type,
                    'latest_message' => $conversation->latestMessage ? [
                        'content' => $conversation->latestMessage->content,
                        'type' => $conversation->latestMessage->type,
                    ] : null,
                    'latest_online_at' => $conversation->latest_online_at
                ];
        })->sortByDesc('latest_online_at');

        $listUserDoesNotHaveConversation = $this->userRepository->getListUserDoesNotHaveConversation(userId: $userId)
            ->limit(config('app.default_page_limit_row'))
            ->offset(($page - config('app.default_page')) * config('app.default_page_limit_row'))
            ->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar_url' => $user->avatar_url,
                'count_unread' => config('app.default_count_unread'),
                'type' => TypeEnum::DOES_NOT_HAVE_CONVERSATION->value,
                'latest_message' => null,
                'latest_online_at' => null
            ];
        })->sortByDesc('created_at');

        return $listConversations->count() ?
            $listConversations->merge(items: $listUserDoesNotHaveConversation) :
            $listUserDoesNotHaveConversation;
    }

    public function getMessageOfConversation(string $conversationOrUserId, int $page, TypeEnum $type): Collection
    {
        if ($type === TypeEnum::DOES_NOT_HAVE_CONVERSATION) {
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

            if (is_null($conversation)) {
                return new Collection();
            }
            /*** @var Conversation $conversation **/
            return $this->messageRepository->getMessageOfConversation(conversationId: $conversation->id)
                ->limit(config('app.default_page_limit_row'))
                ->offset(($page - config('app.default_page')) * config('app.default_page_limit_row'))
                ->orderByDesc('created_at')
                ->get()
                ->reverse()
                ->values();
        }

        $conversation = $this->conversationRepository->findById(conversationId: $conversationOrUserId);

        if (is_null($conversation)) {
            throw new NotFoundHttpException('Conversation not found');
        }

        /** @var UserConversation $conversation */
        $userConversations = $conversation->userConversations()->where('user_id', Auth::id())->first();
        if (! is_null($userConversations)) {
            $userConversations->no_unread_message = 0;
            $userConversations->save();
        }

        return $this->messageRepository->getMessageOfConversation(conversationId: $conversationOrUserId)
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
            $isFirstMessageSingleConversation = false;
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

            if (is_null($conversation)) {
                $isFirstMessageSingleConversation = true;
                /*** @var User $userReceiveMessage **/
                $conversation = $this->createNewConversation(
                    userIds: [Auth::id(), $conversationOrUserId],
                    name: $userReceiveMessage->name,
                    type: TypeEnum::SINGLE
                );
            }

            $this->sendMessageRealtime(conversation: $conversation, message: $message, isFirstMessage: $isFirstMessageSingleConversation);
        }
    }

    public function createNewConversation(array $userIds, string $name, TypeEnum $type): Model
    {
        DB::beginTransaction();
        try {
            $saveConversationDTO = new SaveConversationDTO(
                name: $name,
                type: $type,
                createdBy: Auth::id(),
                latestMessageId: null,
                latestOnlineAt: now()
            );

            $newConversation = $this->conversationRepository->save(saveConversationDTO: $saveConversationDTO);
            /*** @var Conversation $newConversation **/
            $newConversation->users()->sync($userIds);
            DB::commit();

            return $newConversation;
        } catch (Throwable $th) {
            DB::rollBack();

            throw new HttpException(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, message: $th->getMessage());
        }
    }

    private function sendMessageRealtime(Conversation $conversation, string $message, bool $isFirstMessage): void
    {
        $currentUser = Auth::user();
        $users = $conversation->users;

        if (! in_array(Auth::id(), $users->pluck('id')->toArray())) {
            throw new HttpException(statusCode: Response::HTTP_FORBIDDEN, message: 'Bạn đã bị xóa khỏi nhóm!');
        }

         event(new SaveMessageEvent(conversationId: $conversation->id, message: $message, senderId: Auth::id()));
        foreach ($users as $user) {
            /*** @var User $currentUser **/
            broadcast(new SendMessageEvent(
                sender: $currentUser,
                user: $user,
                conversationId: $conversation->id,
                isFirstMessage: $isFirstMessage,
                message: $message
            ))->toOthers();
        }
    }
}
