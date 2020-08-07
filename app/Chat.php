<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public $fillable = [
        'user_id',
    ];

    public function ChatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
}
