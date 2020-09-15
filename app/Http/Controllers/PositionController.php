<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function assign(Request $request)
    {
        $validate = $request -> validate([
            'user_id' => 'required',
            'position' => 'required'
        ]);
        $user = User::findOrFail($request-> user_id);
        $user -> update([
             'position' => $request -> position
        ]);
        return response()->json('Position Updated', 200);
    }
     public function toDefault($user)
    {

        $user = User::findOrFail($user);
        $user -> update([
             'position' => 'manager'
        ]);
        return response()->json('Position reset to manager', 200);
    }

}
