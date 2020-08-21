<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'thumbnail_url',
        'created_by',
    ];

    public function ChatMessages()
    {
        return
        $this->hasMany(ChatMessage::class);
    }
    
    public function users()
    {
        return
        $this->belongsToMany(User::class);
    }
    
}
