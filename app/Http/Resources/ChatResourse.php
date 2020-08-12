<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user()->id;
        $receiverId = $user == $this->user2 ?  $this->user1 :  $this->user2;
        $receiver = User::where('id', $receiverId)->first();
        return [
            'id' => $this->id,
            'sender' => $this->user1,
            'receiver' => $receiver,
            'messages' => $this->ChatMessages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
