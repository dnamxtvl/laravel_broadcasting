<?php

namespace App\Listeners;

use App\DTOs\SaveMessageDTO;
use App\Events\SaveMessageEvent;
use App\Models\Conversation;
use App\Repository\Interface\ConversationRepositoryInterface;
use App\Repository\Interface\MessageRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Whoops\Exception\ErrorException;

class SaveMessageEventAction
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

    /**
     * @throws ErrorException
     */
    public function handle(SaveMessageEvent $event): void
    {
        DB::beginTransaction();
        try {
            $saveMessageDTO = new SaveMessageDTO(
                content: $event->message,
                type: config('message.type.text'),
                conversationId: $event->conversationId,
                senderId: $event->senderId,
                parentId: null
            );

            $this->messageRepository->save(saveMessageDTO: $saveMessageDTO);
            $conversation = $this->conversationRepository->findById(conversationId: $event->conversationId);
            /*** @var Conversation $conversation **/
            $userConversations = $conversation->userConversations()->where('user_id', '!=', $event->senderId)->get();
            $conversation->update(['latest_online_at' => now()]);

            foreach ($userConversations as $userConversation) {
                $userConversation->no_unread_message ++;
                $userConversation->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug(message: $e);

            throw new ErrorException(message: $e->getMessage());
        }
    }
}
