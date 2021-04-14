<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        
        $request->validate([
            'number' => 'required|string',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('number', $request->number)->first();

        // dd($request->password . " " .  $user->password);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'number' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        // return 'tokens deleted';
        return response()->json([
            'success' => 'user is logged out',
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }


}
