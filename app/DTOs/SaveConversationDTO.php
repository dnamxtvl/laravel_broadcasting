<?php

namespace App\DTOs;

use App\Enums\Conversation\TypeEnum;
use Carbon\Carbon;

class SaveConversationDTO
{
    public function __construct(
        private readonly string $name,
        private readonly TypeEnum $type,
        private readonly string $createdBy,
        private readonly ?string $latestMessageId,
        private readonly ?Carbon $latestOnlineAt
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): TypeEnum
    {
        return $this->type;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getLatestMessageId(): ?string
    {
        return $this->latestMessageId;
    }

    public function getLatestOnlineAt(): ?Carbon
    {
        return $this->latestOnlineAt;
    }
}
