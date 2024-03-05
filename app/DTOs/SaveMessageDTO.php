<?php

namespace App\DTOs;

class SaveMessageDTO
{
    public function __construct(
        private readonly string $content,
        private readonly int $type,
        private readonly string $conversationId,
        private readonly string $senderId,
        private readonly ?string $parentId
    ) {}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getConversationId(): string
    {
        return $this->conversationId;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }
}
