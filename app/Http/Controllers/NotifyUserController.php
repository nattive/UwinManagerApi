<?php

namespace App\Http\Controllers;

use App\NotifyUser;
use Illuminate\Http\Request;

class NotifyUserController extends Controller
{
     public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'from_user_id' => '',
            'isRead' => '',
            'type' => '',
            ]);

        $notify = \auth()->user()->NotifyUser()->create($validate);
        return response()->json($notify, 200);
    }
    public function read($id)
    {
        $notification = NotifyUser::findOrFail($id);
        $notification -> update([
            'isRead' => true,
        ]);
        return response()->json('Read!', 200);
    }
     public function readAll($id)
    {
        foreach (\auth() -> user() -> NotifyUser as $notification) {
            $notification -> update([
                'isRead' => true,
            ]);
        }
        return response()->json('Read!', 200);
    }

    public function destroy(NotifyUser $Notification)
    {
        $Notification -> delete();
        return response()->json('Deleted!', 200);
    }

}
