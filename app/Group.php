<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function ChatMessages()
    {
        return
            $this->hasMany(ChatMessage::class);
    }
}
