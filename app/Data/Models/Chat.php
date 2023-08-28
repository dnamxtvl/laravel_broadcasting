<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat';

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    protected $fillable = [
        'send_user_id',
        'to_user_id',
        'message',
        'status',
        'message_felling',
        'group_id'
    ];

    public function userSendMessage()
    {
        return $this->belongsTo(User::class, 'send_user_id', 'id');
    }

    public function userReceiveMessage()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
