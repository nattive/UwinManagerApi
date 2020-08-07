<?php

use App\Broadcasting\OneOnOneChatChannel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('private-chat-{chatId}', function ($user, $chatId) {
     return  $user;
});
Broadcast::channel('chat', function ($user) {
    return $user;
});
Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});