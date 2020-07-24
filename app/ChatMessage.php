<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    
    protected $fillable = [
        'chat_id',
        'user_id',
        'text',
        'group_id',
    ];
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute($time)
    {
        return Carbon::parse($time)->longAbsoluteDiffForHumans();
    }
}
