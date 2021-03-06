<?php

namespace App\Http\Controllers;

 use App\Notifications\UserNotification;
use App\Chat;
use App\ChatMessage;
use App\Events\ChatMessageCreated;
use App\Events\ChatNotification;
use App\Events\GroupChat;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\ChatResourse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{
    public $user;
    public $receiver;
    public function fetchMessages()
    {
        return ChatMessage::with('user')->orderBy('created_at', 'desc')->get();
    }
    public function InitSingleChat(Request $request)
    {
        $user = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);
        if ($user) {
            if ($receiver) {
                $chat = Chat::where([
                    ['user2', '=', $user->id],
                    ['user1', '=', $receiver->id],
                ])->orWhere([
                    ['user1', '=', $user->id],
                    ['user2', '=', $receiver->id],
                ])->first();
                // $chat = Chat::whereHas('users', function ($query) {
                //     $user = auth()->user();
                //     return $query->whereIn('id', [$user->id, request('receiver_id') ]);
                // })->get()->first();
                if ($chat) {
                    return response()->json(['channel' => "private-chat-" . $chat->id, 'chat' => $chat]);
                } else {
                    $chat = new Chat();
                    $chat->user1 = $user->id;
                    $chat->user2 = $receiver->id;
                    $chat->save();
                    // $chat -> users() -> attach($receiver, , ['type' => 'receiver']);
                    return response()->json(['channel' => "private-chat-" . $chat->id, 'channel2' => "private-chat-" . $receiver->id, 'chat' => $chat]);
                }
            } else {
                return response()->json('Receiver not found', 404);
            }
        } else {
            return response()->json('You are not signed in', 401);
        }
    }
    public function sendMessage(Request $request)
    {
        // return $request->all();
        $validate = $request->validate([
            'receiver_id' => 'required|int',
            'text' => 'required|max:500',
            'chatId' => 'required',
        ]);
        $user = auth()->user();
        if ($user) {
            $receiver = User::where('id', $request->receiver_id)->first();
            if ($receiver) {
                $chat = Chat::where('id', $request->chatId)->first();
                $ChatMessage = ChatMessage::create([
                    'user_id' => $user->id,
                    'user' => $user,
                    'receiver_id' => $request->receiver_id,
                    'text' => $request->text,
                    'chat_id' => $chat->id,
                ]);
                $body = [
                    'ChatMessage' => $ChatMessage,
                ];
                new UserNotification( $receiver, 'chat',  $body);
                broadcast(new ChatNotification($ChatMessage, $receiver, $user));
                broadcast(new ChatMessageCreated($ChatMessage))->toOthers();
                return response()->json(['receiver' => $receiver], 200);
            }
        } else {
            return response()->json('You are not signed in', 401);
        }
    }

    public function getOnlineManagers()
    {
        $managers = User::where([
            ['isActive', '=', true],
            ['isOnline', '=', true],
        ])->get();

        return response()->json($managers, 200);
    }

    public function readMessage($id)
    {
        $ChatMessage = ChatMessage::findOrFail($id);
        if(auth()->user()->id == $ChatMessage -> user_id){
            $ChatMessage -> update([
                'isRead' => true
            ]);
        }
        return $ChatMessage;

    }

    public function getChat($id)
    {
        $user = auth()->user();
        if ($user) {
            $chat = Chat::where(['user_id' => $user->id, 'receiver_id' => $id])->first();
            return $chat ? response()->json($chat, 200) : response()->json('Chat not found', 404);
        } else {
            return response()->json('Please sign in', 401);
        }
    }

    public function getMessagesByChat($id)
    {
        $chat = Chat::where('id', $id)->first();
        if ($chat) {
            return response(['chat' => $chat, 'messages' => ChatMessageResource::collection($chat->ChatMessages)]);
        }
        return response()->json('Chat not found', 404);
    }

    public function getAllChat()
    {
        $user = auth()->user();
        $chat = Chat::where('user2', $user->id)->orWhere('user1', $user->id)->get();
        return ChatResourse::collection($chat);
    }
}
