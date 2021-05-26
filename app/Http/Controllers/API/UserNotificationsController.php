<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->notifications()->get();
        return UserNotification::where('user_id', Auth::user()->id)->get();
    }

    // public function subscribe(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required|unique:expo_tokens',
    //     ]);
    //     ExpoToken::create([
    //         'notifiable_id' => Auth::user()->id,
    //         'notifiable_type' => User::class,
    //         'token' => $request->token
    //     ]);

    //     return response()->json(['success' => 'token is successfully registered']);
    // }

    // public function unsubscribe(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'token' => 'required|exists:expo_tokens,token',
    //     ]);

    //     ExpoToken::where([
    //         'notifiable_id' => Auth::user()->id,
    //         'token' => $request->token
    //     ])->first()->delete();

    //     return response()->json(['success' => 'token is successfully omitted']);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotification $userNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $userNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotification $userNotification)
    {
        //
    }
}
