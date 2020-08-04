<?php

namespace App\Broadcasting;

use App\Chat;
use App\User;

class PrivateChatChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, Chat $chat)
    {
        return true;
        // return $chat->users->contains($user);
    }
}
