<?php

namespace App\Repository\Implement;

use App\DTOs\SaveConversationDTO;
use App\Models\Conversation;
use App\Pipeline\Global\UserIdFilter;
use App\Repository\Interface\ConversationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function __construct(
        private readonly Conversation $conversation
    ) {}

    public function getQuery(array $columnSelects = [], array $filters = []): Builder
    {
        $query = $this->conversation->query();
        if (count($columnSelects)) {
            $query->select(columns:  $columnSelects);
        }

        return app(Pipeline::class)
            ->send($query)
            ->through([
                new UserIdFilter(filters: $filters),
            ])
            ->thenReturn();
    }

    public function getListConversations(string $userId): Builder
    {
        return $this->conversation->query()
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['users:id,name,avatar_url', 'createdByUser:id,name,avatar_url'])
            ->with('userConversations', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('latestMessage', function ($query) {
                $query->with('userSend:id,name');
            });
    }

    public function findById(string $conversationId): ?Model
    {
        return $this->conversation->query()->with('users')->find(id: $conversationId);
    }

    public function save(SaveConversationDTO $saveConversationDTO): Model
    {
        $conversation = new Conversation();

        $conversation->name = $saveConversationDTO->getName();
        $conversation->type = $saveConversationDTO->getType()->value;
        $conversation->created_by = $saveConversationDTO->getCreatedBy();
        $conversation->latest_message_id = $saveConversationDTO->getLatestMessageId();
        $conversation->latest_online_at = $saveConversationDTO->getLatestOnlineAt();
        $conversation->save();

        return $conversation;
    }
}
