<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Filters\OrderFilters;
use App\Filters\ReviewFilters;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{

    public function index(Request $request, OrderFilters $filters)
    {
        return Order::filter($filters)->get();
    }
    public function reviewsIndex(Request $request, ReviewFilters $filters)
    {
        return Review::filter($filters)->get();
    }

    public function newOrders(Request $request)
    {
        return Order::where('status', 'new')->get();
    }
    public function resumedOrders(Request $request)
    {
        return Order::where('status', 'resumed')->get();
    }
    public function doneOrders(Request $request)
    {
        return Order::where('status', 'done')->get();
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
