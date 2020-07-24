<?php

namespace App\Observers;

use App\Chat;
use App\ChatMessage;
use App\Events\PeerTOPeerMessageCreatedEvent;
use App\User;

class PrivateChatObserver
{
    /**
     * Handle the chat message "created" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function created(User $user,  ChatMessage $chatMessage, Chat $receiver)
    {
        broadcast(new PeerTOPeerMessageCreatedEvent($user, $chatMessage, $receiver));
    }
}
