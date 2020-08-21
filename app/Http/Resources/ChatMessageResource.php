<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * receiver_id
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sender = User::where('id', $this->user_id)->first();
        $receiver = User::where('id', $this->receiver_id)->first();
        return [
            'id' => $this->id,
            'text' => $this->text,
            'type' => 'text',
            'createdAt' => $this->updated_at,
            'timestamp' => $this->updated_at,
            'author' => [
                'id' => $sender->id,
                'avatarUrl' => $sender->thumbnail_url,
                'username' => $sender->name,
                'email' => $sender->email,
                'location' => $sender->location,
                'phoneNumber' => $sender->phoneNumber,
                'isOnline' => $sender->isOnline,
            ],
        ];
    }
}
