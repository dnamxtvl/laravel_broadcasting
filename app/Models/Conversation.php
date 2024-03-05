<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @property mixed $users
 * @property mixed $id
 */
class Conversation extends Model
{
    use HasFactory, HasUuids;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_conversations', 'conversation_id', 'user_id');
    }

    public function userConversations(): HasMany
    {
        return $this->hasMany(UserConversation::class);
    }

    public function latestMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'latest_message_id', 'id');
    }
}
