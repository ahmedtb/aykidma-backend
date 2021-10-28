<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProvidersController extends Controller
{

    public function showActivated($id)
    {
        Validator::validate(['id' => $id], ['id' => 'required|exists:service_providers,id']);
        $provider = ServiceProvider::where('id', $id)->where('activated', true)->first();
        if($provider){
            $provider->makeVisible('image');
            return $provider;
        }else{
            throw ValidationException::withMessages(['id'=>'there is no activated provider with this id']);
        }
    }

    public function providerApprovedServices($id)
    {
        Validator::validate(['id' => $id], ['id' => 'required|exists:service_providers,id']);
        $provider = ServiceProvider::where('id', $id)->where('activated', true)->first();
        return $provider->approvedServices;
    }

    public function fetchImage($id){
        Validator::validate(['id' => $id], ['id' => 'required|exists:service_providers,id']);
        $provider = ServiceProvider::where('id', $id)->where('activated', true)->first();
        return $provider->image;
    }
}
