<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function allOffers()
    {
        $offers = Offer::all();
        return $offers;
    }

    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string',
    //         'description' => 'required|string',
    //         'fields' => 'required|array',
    //         'meta_data' => 'required|array',
    //         'details' => 'sometimes|required|string'
    //     ]);
    //     $offer = Offer::create([
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'fields' => $request->fields,
    //         'meta_data' => $request->meta_data,
    //     ]);
    //     Service::create([
    //         'service_provider_id' => $request->user()->id,
    //         'offer_id' => $offer->id,
    //         'meta_data' => ['details'=>$request->details]
    //     ]);

    //     return response(['message' => 'offer and service successfully created'], 201);
    // }
}