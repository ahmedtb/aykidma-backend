<?php

namespace App\Http\Controllers;

use App\Models\activationNumber;
use App\Models\User;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {

        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        // dd($request->password . " " .  $user->password);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone_number' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
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

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        $activationNumber = activationNumber::where('phone_number', $request->phone_number)->first();

        if (!$activationNumber) {
            $randomNumber = random_int(1, 65535);
            activationNumber::create([
                'activationNumber' => $randomNumber,
                'phone_number' => $request->phone_number
            ]);
            // where will be code to send the number through whatsapp message

            return response(['message' => 'activation number is created'], 201);
        } else {
            if ($activationNumber->activationNumber == $request->activationNumber) {

                // dd($request->phone_number);
                User::create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'phone_number_verified_at' => now(),
                    'password' => Hash::make($request->password),
                ]);
                $activationNumber->delete();

                return response(['message' => 'user is successfully created'], 201);
            } else {
                return response(['message' => 'the activation number is wrong'], 422);
            }
        }
    }

    public function enrollProvider(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        $activationNumber = activationNumber::where('phone_number', $request->phone_number)->first();

        if (!$activationNumber) {
            $randomNumber = random_int(1, 65535);
            activationNumber::create([
                'activationNumber' => $randomNumber,
                'phone_number' => $request->phone_number
            ]);
            // where will be code to send the number through whatsapp message

            return response(['message' => 'activation number is created'], 201);
        } else {
            if ($activationNumber->activationNumber == $request->activationNumber) {

                ServiceProvider::create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'phone_number_verified_at' => now(),
                    "image" => null,
                    "meta_data" => [
                        // "description" => "هذا وصف اختباري",
                        // "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]]
                    ],
                    'password' => Hash::make($request->password)
                ]);

                $activationNumber->delete();

                return response(['message' => 'provider is successfully created'], 201);
            } else {
                return response(['message' => 'the activation number is wrong'], 422);
            }
        }
    }
}
