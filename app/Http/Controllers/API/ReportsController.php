<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Report;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ReportsController extends Controller
{

    public function reportReview(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'body' => 'required|string|min:10'
        ]);
        $review = Review::where('id', $request->review_id)->first();
        
        Report::create([
            'reportable_type' => Review::class,
            'reportable_id' => $review->id,
            'body' => $request->body
        ]);

        return response()->json(['success' => 'report is created on review comment'], 201);
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
