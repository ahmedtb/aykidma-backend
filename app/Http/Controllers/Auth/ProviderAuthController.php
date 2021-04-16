<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
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
            ]);
    
            $provider = ServiceProvider::where('phone_number', $request->phone_number)->first();
    
            if (!$provider || !Hash::check($request->password, $provider->password)) {
                throw ValidationException::withMessages([
                    'phone_number' => ['The provided credentials are incorrect.'],
                ]);
            }
    
            return response()->json([
                'provider' => $provider,
                'token' => $provider->createToken('mobile'
                // , ['role:provider']
                )->plainTextToken
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
}
