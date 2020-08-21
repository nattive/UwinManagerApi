<?php

namespace App\Http\Controllers;
use App\Http\Resources\ChatMessageResource;
use App\Events\GroupChat;
use App\Events\GroupCreated;
use App\Group;
use App\Http\Resources\GroupChatResource;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function init($id)
    {
        $user = auth()->user();
        $group = Group::where('id', $id)->with('users')->first();
        $exist = $group->users->contains($user);
        if ($exist) {
            return new GroupChatResource($group);
        }
        return response()->json('You are not permitted to join this group', 401);
    }
    public function store()
    {
        $group = Group::create(['name' => request('name'), 'created_by' => auth()->user()->name]);

        $users = collect(request('users'));
        $users->push(auth()->user()->id);

        $group->users()->attach($users);
        broadcast(new GroupCreated($group))->toOthers();

        return new GroupChatResource($group);
    }

    public function update($id)
    {
        $group = Group::where('id', $id)->first();
        if ($group) {
            $group->name = request('name');
            return response()->json('Group name changed successfully', 200);
        } else {
            return response()->json('Group not found', 404);
        }
    }

    public function addUser()
    {
        $group = Group::where('id', request('group_id'))->first();
        $users = collect(request('users'));
        $users->push(auth()->user()->id);
        $group->users()->attach($users);
    }

    public function groupChat()
    {
        $user = auth()->user();
        $group = Group::where('id', \request('group_id'))->with('users')->first();
        $exist = $group->users->contains($user);

        if ($exist) {
            $group->ChatMessages()->create([
                'text' => request('text'),
                'group_id' => request('group_id'),
                'user_id' => auth()->user()->id,
            ]);
            broadcast(new GroupChat($group, request('group_id')))->toOthers();
            return $group->ChatMessages;
        }
        return response()->json('You cant post in this group', 401);

    }

    public function myGroup()
    {
        $user = auth()->user();
        return GroupChatResource::collection($user->groups);
    }

    public function getChat($id)
    {
        $user = auth()->user();
        $group = Group::where('id', $id)->with('users')->first();
        $exist = $group->users->contains($user);

        if ($user) {
            $ChatMessages =  $group->ChatMessages;
           return response(['chat' => $group, 'messages' => ChatMessageResource::collection($ChatMessages)]);
        } else {
            return response()->json('Please sign in', 401);
        }
    }

}
