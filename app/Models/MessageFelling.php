<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFelling extends Model
{
    use HasFactory;

    protected $table = 'message_fellings';

    protected $fillable = [
        'icon',
        'color'
    ];
}
