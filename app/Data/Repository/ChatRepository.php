<?php

namespace App\Data\Repository;

use App\Data\Models\Chat;
use App\Domains\Chat\Enums\StatusEnums;
use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ChatRepository implements ChatRepositoryInterface
{
    public function __construct(
        private readonly Chat $chat
    ) {}
    public function latestToUser(int $userId): Model|null
    {
        return $this->chat->query()
            ->whereNull('group_id')
            ->where('send_user_id', $userId)
            ->orderByDesc('created_at')
            ->first();
    }

    public function changeStatus(int $fromUserId, int $toUserId, StatusEnums $status): void
    {
        $this->chat->query()
            ->where('to_user_id', $fromUserId)
            ->where('send_user_id', $toUserId)->update(
                [
                    'status' => $status->value
                ]
            );
    }

    public function getMessageDetail(int $fromUserId, int $toUserId, int $limit, int $offset): Collection
    {
        return $this->chat->query()
            ->whereNull('group_id')
            ->with([
                'userSendMessage:id,name,avatar',
                'userReceiveMessage:id,name,avatar'
            ])
            ->where(function ($query2) use ($fromUserId, $toUserId) {
                $query2->where(function ($query) use ($fromUserId, $toUserId) {
                    $query->where('send_user_id', $fromUserId)
                        ->where('to_user_id', $toUserId);
                })->orWhere(function ($query1) use ($fromUserId, $toUserId) {
                    $query1->where('to_user_id', $fromUserId)
                        ->where('send_user_id', $toUserId);
                });
            })
            ->take($limit)
            ->skip($offset)
            ->orderByDesc('created_at')
            ->get();
    }
}
