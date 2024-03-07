<?php

namespace App\Repository\Interface;

use App\DTOs\SaveConversationDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ConversationRepositoryInterface
{
    public function getQuery(array $columnSelects = [], array $filters = []): Builder;

    public function getListConversations(string $userId): Builder;

    public function findById(string $conversationId): ?Model;

    public function save(SaveConversationDTO $saveConversationDTO): Model;
}
