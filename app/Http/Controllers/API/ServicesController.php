<?php

namespace App\Http\Controllers\API;

use App\Models\Offer;

use App\Rules\Base64Rule;
use App\Models\Service;
use App\Rules\LongString;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Rules\ArrayOfFieldsRule;
use App\Http\Controllers\Controller;
use App\Rules\PhoneNumberRule;
use Illuminate\Validation\ValidationException;

class ServicesController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'array_of_fields' => ['required', new ArrayOfFieldsRule()],
            'category_id' => 'required|exists:categories,id',
            'image' => ['sometimes', new Base64Rule(8000000)],
            'meta_data' => 'present|array',
            'phone_number' => ['sometimes', new PhoneNumberRule],

        ]);
        // this line needs further examination
        $data['image'] = $data['image'] ?? getBase64DefaultImage();
        // set service phone number the same as provider if it is not in the inputs
        $data['phone_number'] = $data['phone_number'] ?? $request->user('provider')->phone_number;

        $data['service_provider_id'] = $request->user('provider')->id;
        Service::create($data);

        return response(['message' => 'service successfully created'], 201);
    }

    public function myServices(Request $request)
    {
        return Auth()->user('provider')->Services()->get();
    }


    public function allServices()
    {
        return Service::all();
    }

    public function allApprovedServices()
    {
        return Service::where('approved', true)
            // ->with(['ServiceProvider', 'reviews'])
            ->get();
    }


    public function byCategory(Request $request, $category_id)
    {
        validator($request->route()->parameters(), [
            'category_id' => 'required|integer'
        ])->validate();

        return Service::where('approved', true)->where('category_id', $category_id)
            // ->with(['ServiceProvider', 'reviews'])
            ->get();
    }

    public function edit(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'array_of_fields' => ['sometimes', new ArrayOfFieldsRule()],
            'category_id' => 'sometimes|exists:categories,id',
            'image' => ['sometimes', new Base64Rule(8000000)],
            'meta_data' => 'sometimes|array',
        ]);

        $service = $request->user('provider')->Services()->where('id', $id)->first();
        // $data['service_provider_id'] = $request->user()->id;
        // Service::create($data);
        $service->update($data);

        return ['success' => 'the service is edited'];
    }

    public function showPhoneNumber(Request $request, $id)
    {
        $user = $request->user('user');
        if ($user->orders()->where('status', 'resumed')->where('service_id', $id)->count() > 0)
            return Service::where('id', $id)->first()->phone_number;
        else {
            throw ValidationException::withMessages(['orders' => 'you dont have resumed orders for this service']);
        }
    }
}
