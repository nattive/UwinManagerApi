<?php

namespace App\Observers;

use App\ChatMessage;
use App\Events\ChatMessageCreated as ChatMessageCreatedEvent;

class ChatMessageObserver
{
    /**
     * Handle the chat message "created" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function created(ChatMessage $chatMessage)
    {
        broadcast(new ChatMessageCreatedEvent($chatMessage));

    }

}
