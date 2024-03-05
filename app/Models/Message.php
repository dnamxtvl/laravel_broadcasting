<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @property mixed|string $content
 * @property int|mixed $type
 * @property mixed|string $sender_id
 * @property mixed|string $conversation_id
 * @property mixed|string|null $parent_id
 */
class Message extends Model
{
    use HasFactory, HasUuids;

    public function userSend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function messageFeelings(): HasMany
    {
        return $this->hasMany(MessageFeeling::class);
    }
}
