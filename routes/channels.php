<?php

use App\Chat;
use App\Group;
use App\ChatMessage;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

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

Broadcast::channel('notification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id ? $user : null;
});

Broadcast::channel('private-chat-{id}', function ($user, $id) {
    $chat = Chat::where('id', $id)->first();
    if ($chat->user1 == $user->id) {
        return $user;
    } else if ($chat->user2 == $user->id) {
        return $user;
    } else {
        return null;
    }
});

Broadcast::channel('available', function ($user) {
    return $user;
});

Broadcast::channel('group-{id}', function ($user, $id) {
    $group = Group::where('id', $id)->with('users')->first();
    $exist = $group->users->contains($user);
    return $exist ? $user : null;
});

Broadcast::channel('chat', function ($user, $chatId) {
    $chat = ChatMessage::where('id', $chatId)->first();
    if ($chat->user1 == $user->id) {
        return $user;
    } else if ($chat->user2 == $user->id) {

        return $user;
    } else {
        return null;
    }
});

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
