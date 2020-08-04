<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatMessage;
use App\Events\ChatMessageCreated;
use App\Events\GroupChat;
use App\Events\MessageSent;
use App\Events\PeerTOPeerMessageCreatedEvent;
use App\Http\Resources\ChatResource;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        return ChatMessage::with('user')->get();
    }
    public function InitSingleChat(Request $request)
    {
        $user = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);
        if ($user) {
            if ($receiver) {
                $chat = Chat::where([
                    ['user_id', $user->id],
                    ['receiver_id', $request->receiver_id]
                ])
                    ->orWhere([['user_id', $request->receiver_id], ['receiver_id',  $user->id]])->first();
                if ($chat) {
                    return response()->json(['channel' => "private-chat-" . $chat->id, 'chat' => $chat]);
                } else {
                    $chat = $user->chats()->create([
                        'user_id' => auth()->user()->id,
                        'receiver_id' => $request->receiver_id
                    ]);
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
        $user =  auth()->user();
        if ($user) {
            $receiver = User::where('id', $request->receiver_id)->first();
            if ($receiver) {
                $chat = Chat::where('id', $request->chatId)->first();
                $ChatMessage = ChatMessage::create([
                    'user_id' => $user->id,
                    'text' => $request->text,
                    'chat_id' =>  $chat->id,
                ]);
                broadcast(new ChatMessageCreated($ChatMessage));

                return response()->json(['receiver' => $receiver], 200);
            }
        } else {
            return response()->json('You are not signed in', 401);
        }
    }

    public function groupChat()
    {
        $conversation = ChatMessage::create([
            'text' => request('text'),
            'group_id' => request('group_id'),
            'user_id' => auth()->user()->id,
        ]);
        broadcast(new GroupChat($conversation))->toOthers();

        return $conversation->load('user');
    }

    public function getChat($id)
    {
        $user = auth()->user();
        if ($user) {
            $chat = Chat::where(['user_id' => $user->id, 'receiver_id' => $id])->first();
            return  $chat ? response()->json($chat, 200) : response()->json('Chat not found', 404);
        } else {
            return response()->json('Please sign in', 401);
        }
    }

    public function getMessagesByChat($id)
    {
        $chat = Chat::where('id', $id)->with('ChatMessages')->first();
        if ($chat) {
            return new ChatResource($chat);
        }
        return  response()->json('Chat not found', 404);
    }
}
