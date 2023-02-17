<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $table = 'group_chat';

    protected $fillable = [
        'name',
        'option_status',
        'type'
    ];
}
