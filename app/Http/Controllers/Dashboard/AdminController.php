<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\ProviderEnrollmentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //
    public function listOfNotApprovedServices()
    {
        $services = Service::where('approved', false)->with(['ServiceProvider'])->get();
        return view('dashboard', ['services' => $services]);
    }

    public function approveService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer'
        ]);
        $service = Service::where('id', $request->service_id)->first();
        if ($service) {
            if ($service->approved) {
                return response(['failure' => 'the service is already approved'], 404);
            }
            $service->approved = true;
            $service->save();
            return response(['success' => 'the service has been approved']);
        } else {
            $error = ValidationException::withMessages([
                'service_id' => ['this service does not exist'],
            ]);
            throw $error;
        }
    }

    public function rejectService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer'
        ]);
        $service = Service::where('id', $request->service_id)->first();
        if ($service) {
            if ($service->approved) {
                return response(['failure' => 'the service is already approved'], 404);
            }
            // $service->approved = true;
            $service->delete();
            return response(['success' => 'the service has been rejected']);
        } else {
            $error = ValidationException::withMessages([
                'service_id' => ['this service does not exist'],
            ]);
            throw $error;
        }
    }

    public function approveProvider($id)
    {

        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|exists:provider_enrollment_requests,id'
        ]);

        $enrollmentRequest = ProviderEnrollmentRequest::where('id', $id)->first();

        $provider = ServiceProvider::where('id', $enrollmentRequest->user_id)->first();

        if (!$provider)
            $provider = ServiceProvider::create([
                'name' => $enrollmentRequest->name,
                'coverage' => $enrollmentRequest->coverage,
                'user_id' => $enrollmentRequest->user_id,
                'activated' => true,
            ]);
        else
            $provider->update([
                'name' => $enrollmentRequest->name,
                'coverage' => $enrollmentRequest->coverage,
                'activated' => true
            ]);
        $enrollmentRequest->delete();
        return ['success' => 'the provider has been approved'];
    }
}
