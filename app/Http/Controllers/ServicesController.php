<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceProvider;

class ServicesController extends Controller
{
    
    public function getOfferServices($offer_id)
    {
        $services = Service::where('offer_id',$offer_id)->with('ServiceProvider')->get();
        return $services;
    }

    public function create(Request $request)
    {
        $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'offer_id' => 'required|exists:offers,id',
            'meta_data' => 'array'
        ]);

        Service::create([
            'service_provider_id' => $request->service_provider_id,
            'offer_id' => $request->offer_id,
            'meta_data' => $request->meta_data
        ]);

        return response(['message' => 'service successfully created'], 201);
    }

    public function myServices(Request $request)
    {
        // $services = Service::where('service_provider_id',$request->service_provider_id)->get();
        return Auth()->user()->Services()->with(['offer'])->get();
    }
}
