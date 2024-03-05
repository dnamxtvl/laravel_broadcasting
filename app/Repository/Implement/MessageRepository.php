<?php

namespace App\Repository\Implement;

use App\DTOs\SaveMessageDTO;
use App\Models\Message;
use App\Pipeline\Global\ConversationIdFilter;
use App\Pipeline\Global\UserIdFilter;
use App\Repository\Interface\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class MessageRepository implements MessageRepositoryInterface
{
    public function __construct(
        private readonly Message $message
    ) {}

    public function getQuery(array $columnSelects = [], array $filters = []): Builder
    {
        $query = $this->message->query();
        if (count($columnSelects)) {
            $query->select(columns:  $columnSelects);
        }

        return app(Pipeline::class)
            ->send($query)
            ->through([
                new UserIdFilter(filters: $filters),
                new ConversationIdFilter(filters: $filters),
            ])
            ->thenReturn();
    }
    public function getMessageOfConversation(string $conversationId): Builder
    {
        $filters = ['conversation_id' => $conversationId];

        return $this->getQuery(filters: $filters)
            ->with(['userSend:id,name,avatar_url', 'messageFeelings.user:id,name,avatar_url']);
    }

    public function save(SaveMessageDTO $saveMessageDTO): void
    {
        $message = new Message();

        $message->content = $saveMessageDTO->getContent();
        $message->type = $saveMessageDTO->getType();
        $message->sender_id = $saveMessageDTO->getSenderId();
        $message->conversation_id = $saveMessageDTO->getConversationId();
        $message->parent_id = $saveMessageDTO->getParentId();
        $message->save();
    }
}
