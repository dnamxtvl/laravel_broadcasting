<?php

namespace App\Services\Interface;

use App\Enums\Conversation\TypeEnum;
use Illuminate\Support\Collection;

interface ChatServiceInterface
{
    public function getListConversations(string $userId, int $page): Collection;

    public function getMessageOfConversation(string $conversationId, int $page): Collection;

    public function sendMessage(string $conversationOrUserId, string $message, TypeEnum $type): void;
}
