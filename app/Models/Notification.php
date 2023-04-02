<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Notification extends Eloquent
{
    protected $collection = 'notification';
    protected $connection = 'mongodb';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'user_id',
        'link',
        'test'
    ];
}
