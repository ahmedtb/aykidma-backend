<?php

namespace App\Http\Controllers\API\Auth;

use App\Rules\Base64Rule;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\activationNumber;
use App\Http\Controllers\Controller;
use App\Models\ProviderEnrollmentRequest;
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

        $date = $request->validate([
            'name' => 'required|string|unique:service_providers,name',
            'coverage' => 'sometimes|array',
            'coverage.*.city' => 'required|string',
            'coverage.*.area' => 'required|string',
            // 'user_id' => 'required|exists:users,id'
        ]);

        ProviderEnrollmentRequest::create([
            'name' => $request->name,
            'coverage' => $request->coverage,
            'user_id' => $request->user()->id,
        ]);

        return response(['success' => 'provider enrollemnt is submitted'], 200);
    }

    public function provider(Request $request)
    {
        // dd($request->user('sanctum'));
        return $request->user()->provider;
    }

    public function myImage(Request $request)
    {
        return $request->user()->image ?? getBase64DefaultImage();
    }


    public function editProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string',
            // 'phone_number' => 'sometimes|string',
            'image' => ['sometimes', new Base64Rule(100000)]
        ]);
        $user = $request->user();
        $user->update($validatedData);
        $user->save();
        return response(['success' => 'provider profile edited']);
    }
}
