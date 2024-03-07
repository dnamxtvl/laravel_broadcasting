<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed $users
 * @property mixed $id
 * @property mixed|string $name
 * @property int|mixed $type
 * @property mixed|string $created_by
 * @property mixed|string $latest_message_id
 * @property Carbon|mixed $latest_online_at
 */
class Conversation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
        'created_by',
        'latest_message_id',
        'latest_online_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_conversations', 'conversation_id', 'user_id')
            ->using(new class extends Pivot {
                use HasUuids;
            })->withTimestamps();
    }

    public function userConversations(): HasMany
    {
        return $this->hasMany(UserConversation::class);
    }

    public function latestMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'latest_message_id', 'id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
