<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat';

    protected $fillable = [
        'send_user_id',
        'to_user_id',
        'message',
        'status',
        'message_felling',
        'group_id'
    ];
}
