<?php

namespace App\Http\Resources;

use App\ChatMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'thumbnail_url' => $this->thumbnail_url,
            'created_by' => $this->created_by,
            'last_message' => ChatMessage::where('group_id', $this->id)
                ->orderBy('created_at', 'desc')
                ->first(),
            'messages' => $this->ChatMessages(),
        ];
    }
}
