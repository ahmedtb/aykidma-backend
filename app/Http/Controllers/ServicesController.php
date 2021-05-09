<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
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

    public function createWithOffer(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'fields' => 'required|array',
            'meta_data' => 'present|array',
            'details' => 'sometimes|required|string'
        ]);
        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'meta_data' => $request->meta_data,
        ]);
        Service::create([
            'service_provider_id' => $request->user()->id,
            'offer_id' => $offer->id,
            'meta_data' => ['details'=>$request->details]
        ]);

        return response(['message' => 'offer and service successfully created'], 201);
    }

    public function myServices(Request $request)
    {
        // $services = Service::where('service_provider_id',$request->service_provider_id)->get();
        return Auth()->user()->Services()->with(['offer'])->get();
    }
}
