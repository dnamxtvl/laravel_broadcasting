<?php

namespace App\Repository\Interface;

use App\DTOs\SaveMessageDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface MessageRepositoryInterface
{
    public function getQuery(array $columnSelects = [], array $filters = []): Builder;

    public function getMessageOfConversation(string $conversationId): Builder;

    public function save(SaveMessageDTO $saveMessageDTO): Model;
}
