<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifyUser extends Model
{
    protected $fillable = [
        'title',
        'body',
        'from_user_id',
        'isRead',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
