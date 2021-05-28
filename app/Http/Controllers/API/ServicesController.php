<?php

namespace App\Http\Controllers\API;

use App\Models\Offer;

use App\Models\Service;
use App\Rules\LongString;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'fields' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'image' => 'max:5000',
            'meta_data' => 'present|array',
        ]);
        // this line needs further examination
        $data['image'] = $data['image'] ?? 'https://www.mintformations.co.uk/blog/wp-content/uploads/2020/05/shutterstock_583717939.jpg';

        $data['service_provider_id'] = $request->user()->id;
        Service::create($data);

        return response(['message' => 'service successfully created'], 201);
    }

    public function myServices(Request $request)
    {
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
