<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\ProviderEnrollmentRequest;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

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

    public function deleteReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer'
        ]);

        $order = Order::where(['orders.id' => $request->order_id, 'status' => 'done'])->first();

        if ($order) {
            if ($request->comment) {
                $order->comment = $request->comment;
            }
            if ($request->rating) {
                $order->rating = $request->rating;
            }
            $order->save();
            return response(['success' => 'review deleted']);
        } else
            return response(['failed' => 'there is no a done order that belongs to you with this id'], 400);
    }

    public function approveProvider(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        $provider = ServiceProvider::where('id', $request->user_id)->first();

        $enrollmentRequest = ProviderEnrollmentRequest::where('user_id', $request->user_id)->first();

        $provider->update([
            'name' => $enrollmentRequest->name,
            'coverage' => $enrollmentRequest->coverage,
            'activated' => true
        ]);
        return ['success' => 'the provider has been approved'];
        // return $enrollmentRequest;
    }
}
