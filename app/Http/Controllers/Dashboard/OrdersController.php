<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\OrderFilters;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{

    public function index(Request $request, OrderFilters $filters)
    {

        return Order::filter($filters)->with($request->with)->get();
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
}
