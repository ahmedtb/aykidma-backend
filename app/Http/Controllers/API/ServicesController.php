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
            'image' => 'sometimes|max:5000',
            'meta_data' => 'present|array',
        ]);
        // this line needs further examination
        $data['image'] = $data['image'] ?? getBase64DefaultImage();

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
        return Service::where('approved', true)->get();
    }


    public function byCategory(Request $request, $category_id)
    {
        validator($request->route()->parameters(), [
            'category_id' => 'required|integer'
        ])->validate();

        return Service::where('approved', true)->where('category_id', $category_id)->get();
    }

    public function edit(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'fields' => 'sometimes|array',
            'category_id' => 'sometimes|exists:categories,id',
            'image' => 'sometimes',
            'meta_data' => 'sometimes|array',
        ]);

        $service = $request->user()->Services()->where('id',$id)->first();
        // $data['service_provider_id'] = $request->user()->id;
        // Service::create($data);
        $service->update($data);

        return response(null, 204);
    }
}
