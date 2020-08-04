<?php

namespace App\Broadcasting;

use App\Chat;
use App\User;
use Illuminate\Support\Facades\Auth;

class OneOnOneChatChannel
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
    public function join(Chat $chat)
    {
     return true;
    }
}
