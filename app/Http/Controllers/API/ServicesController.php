<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;

class ServicesController extends Controller
{
    
    // public function getOfferServices($offer_id)
    // {
    //     $services = Service::where('offer_id',$offer_id)->with('ServiceProvider')->get();
    //     return $services;
    // }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'fields' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|string',
            'meta_data' => 'present|array',
        ]);

        Service::create([
            'service_provider_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'category_id' => $request->category_id,
            'image' => $request->image,
            'meta_data' => $request->meta_data,
        ]);

        return response(['message' => 'service successfully created'], 201);
    }

    public function createWithOffer(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'fields' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'meta_data' => 'present|array',
            'details' => 'sometimes|required|string'
        ]);
        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'category_id' => $request->category_id,
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
        return Auth()->user()->Services()->get();
    }


    public function allServices()
    {
        return Service::all();
    }

    public function allApprovedServices()
    {
        return Service::where('approved',true)->get(); 
    }


    public function byCategory(Request $request, $category_id)
    {
        validator($request->route()->parameters(), [
            'category_id' => 'required|integer'
        ])->validate();

        return Service::where('approved',true)->where('category_id', $category_id)->get();
    }
}
