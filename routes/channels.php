<?php

use App\Broadcasting\OneOnOneChatChannel;
use App\ChatMessage;
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

Broadcast::channel('private-chat-{id}', function ($user, $id) {
    if ( (int) $user->id === (int) $id) {
        return $user;
    }
});
Broadcast::channel('chat', function ($user, $chatId) {
    $chat = ChatMessage::where('id', $chatId)->first();
    if ($chat->user1 == $user->id) {
        return $user;
    } else if ($chat->user2 == $user->id) {

        return  $user;
    } else {
        return null;
    }
});

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
