<?php

namespace App\Listeners;

use App\DTOs\SaveMessageDTO;
use App\Events\SaveMessageEvent;
use App\Repository\Interface\ConversationRepositoryInterface;
use App\Repository\Interface\MessageRepositoryInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveMessageEventAction implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
        private readonly ConversationRepositoryInterface $conversationRepository
    ) {}

    public function handle(SaveMessageEvent $event): void
    {
        DB::beginTransaction();
        try {
            $saveMessageDTO = new SaveMessageDTO(
                content: $event->message,
                type: config('message.type.text'),
                conversationId: $event->conversationId,
                senderId: Auth::id(),
                parentId: null
            );

            $this->messageRepository->save(saveMessageDTO: $saveMessageDTO);
            $conversation = $this->conversationRepository->findById(conversationId: $event->conversationId);
            $userConversations = $conversation->userConversations()->where('user_id', '!=', Auth::id())->get();

            foreach ($userConversations as $userConversation) {
                $userConversation->no_unread_message++;
                $userConversation->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug(message: $e);
        }
    }
}
