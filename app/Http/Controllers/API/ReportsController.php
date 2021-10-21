<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Report;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ReportsController extends Controller
{

    public function reportComment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'body' => 'required|string|min:10'
        ]);
        $order = Order::where('id', $request->order_id)->first();
        if (!$order->comment)
            throw ValidationException::withMessages(['comment' => 'this order does not have a comment']);
        Report::create([
            'reportable_type' => Order::class,
            'reportable_id' => $order->id,
            'body' => $request->body
        ]);

        return response()->json(['success' => 'report is created on order comment'], 201);
    }
    
    public function reportSP(Request $request)
    {
        $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'body' => 'required|string|min:10'
        ]);
        $service_provider = ServiceProvider::where('id', $request->service_provider_id)->first();
        
        Report::create([
            'reportable_type' => ServiceProvider::class,
            'reportable_id' => $service_provider->id,
            'body' => $request->body
        ]);

        return response()->json(['success' => 'report is created about service provider'], 201);
    }

        
    public function reportService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'body' => 'required|string|min:10'
        ]);
        $service = Service::where('id', $request->service_id)->first();
        
        Report::create([
            'reportable_type' => Service::class,
            'reportable_id' => $service->id,
            'body' => $request->body
        ]);

        return response()->json(['success' => 'report is created about service'], 201);
    }
}
