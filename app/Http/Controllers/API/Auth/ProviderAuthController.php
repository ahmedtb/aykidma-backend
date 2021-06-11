<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\activationNumber;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProviderAuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required',
            'expo_token' => 'required|string'
        ]);

        $provider = ServiceProvider::where('phone_number', $request->phone_number)->first();

        if (!$provider || !Hash::check($request->password, $provider->password)) {
            throw ValidationException::withMessages([
                'phone_number' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'provider' => $provider,
            'token' => $provider->createToken('mobile', $request->expo_token)->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // return 'tokens deleted';
        return response()->json([
            'success' => 'provider is logged out',
        ]);
    }
    public function enrollProvider(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|array',
            'address.city' => 'required|string',
            'address.area' => 'required|string',
            'address.subArea' => 'required|string',
            'coverage' => 'required|array',
            'coverage.*.city' => 'required|string',
            'coverage.*.area' => 'required|string',
            'password' => 'required|string',
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

                // dd($request->email);
                ServiceProvider::create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'phone_number_verified_at' => now(),
                    'email' => $request->email,
                    'address' => $request->address,
                    'coverage' => $request->coverage,
                    "image" => getBase64DefaultImage(),
                    // "meta_data" => [
                    //     // "description" => "هذا وصف اختباري",
                    //     // "location" => ["GPS" => ["latitude" => 13.1, "longtitude" => 32.5]]
                    // ],
                    'password' => Hash::make($request->password)
                ]);

                $activationNumber->delete();

                return response(['message' => 'provider is successfully created'], 201);
            } else {
                return response(['message' => 'the activation number is wrong'], 422);
            }
        }
    }

    public function provider(Request $request)
    {
        return $request->user();
    }
}
