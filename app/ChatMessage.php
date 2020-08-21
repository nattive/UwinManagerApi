<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{

    protected $fillable = [
        'chat_id',
        'user_id',
        'receiver_id',
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
        $date = Carbon::parse($time);
        if ($date->isToday()) {
            return $date->format('h:i:s A');
        } else if ($date->isYesterday()) {
            return 'Yesterday ' . $date->format('h:i:s A');
        } else {
            return $date->toFormattedDateString();
        }
    }
}
