<?php

namespace App\Services\Interface;

use App\Enums\Conversation\TypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ChatServiceInterface
{
    public function getListConversations(string $userId, int $page): Collection;

    public function getMessageOfConversation(string $conversationOrUserId, int $page, TypeEnum $type): Collection;

    public function sendMessage(string $conversationOrUserId, string $message, TypeEnum $type): void;

    public function createNewConversation(array $userIds, string $name, TypeEnum $type): Model;
}
