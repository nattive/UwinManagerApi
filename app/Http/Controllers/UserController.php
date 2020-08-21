<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = User::with('roles')->get();
        return response()->json($users, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        $users = User::where([
            ['isActive', '=', true],
            ['id', '!=',  auth()->user()->id],
        ])->get();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        $user = User::where('id', $id)->first();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request -> all();
        $user = User::where('id', $id)->first();
        $user->name = $request->name ?? $user->name;
        $user->isActive = $request->isActive ?? $user->isActive;
        $user->email = $request->email ?? $user->email;
        $user->head_of_manager_id = $request->head_of_manager_id ?? $user->head_of_manager_id;
        $user->location = $request->location ?? $user->location;
        $user->phoneNumber = $request->phoneNumber ?? $user->phoneNumber;
        $user->guarantorPhone = $request->guarantorPhone ?? $user->guarantorPhone;
        $user->guarantorAddress = $request->guarantorAddress ?? $user->guarantorAddress;
        $user->thumbnail_url = $request->thumbnail_url ?? $user->thumbnail_url;
        $user->url = $request->url ?? $user->url;
        $user->isOnline = $request->isOnline ?? $user->isOnline;
        $user->email_verified_at = $request->email_verified_at ?? $user->email_verified_at;
        $user->password = $request->password ? bcrypt($request->password) : $user->password;
        $user->save();
        $role = $user->roles()->first();
        return response()->json(compact('user', 'role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
