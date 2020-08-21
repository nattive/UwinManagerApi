<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\GroupCreated;
use App\Group;
use App\User;
use App\Http\Resources\GroupChatResource;
use Illuminate\Http\Request;

class GroupController extends Controller
{
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
        $conversation = ChatMessage::create([
            'text' => request('text'),
            'group_id' => request('group_id'),
            'user_id' => auth()->user()->id,
        ]);
        broadcast(new GroupChat($conversation))->toOthers();

        return $conversation->load('user');
    }

    public function myGroup()
    {
        $user = auth()->user();
        return GroupChatResource::collection($user->groups);
    }
}
