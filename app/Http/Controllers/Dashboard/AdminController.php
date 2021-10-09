<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\ProviderEnrollmentRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\MessageNotification;
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
        $provider->user->notify(new MessageNotification('provider enrollement', 'congratulation, your provider account enrollment is accepeted', 'user'));

        return ['success' => 'the provider enrollment request has been approved'];
    }

    public function activateProvider($id){
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|exists:service_providers,id'
        ]);
        $provider = ServiceProvider::where('id', $id)->first();
        $provider->update([
            'activated' => true
        ]);

        $provider->user->notify(new MessageNotification('provider activated', 'congratulation, your provider account is active now', 'user'));

        return ['success' => 'the provider has been activated'];

    }

    public function deleteReview(Request $request)
    {
        // dd('dsad');
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::where(['orders.id' => $request->order_id, 'status' => 'done'])->first();

        if ($order) {
            $order->comment = null;
            $order->rating = null;
            $order->save();
            return response(['success' => 'review deleted']);
        } else
            return response(['failed' => 'there is no a done order that belongs with this id'], 400);
    }
}
