<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['text'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute($time){
        return Carbon::parse($time)->diffForHumans();
    }
}
