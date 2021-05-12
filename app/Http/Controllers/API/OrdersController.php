<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Offer;
use App\Models\Order;
use App\Models\Service;
use App\Rules\FieldsMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{

    public function getServiceOrders(Request $request)
    {
        return Auth::user()->orders()->where('service_id', $request->service_id)->with(['service.offer', 'service.ServiceProvider'])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->orders()->with(['service.offer', 'service.ServiceProvider'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'fields' => ['required', 'array'],
            'fields.*.type' => 'string|required',
            'fields.*.label' => 'string|required',
            'fields.*.value' => 'required',
        ]);

        $service = Service::where('id', $request->service_id)->first();

        $request->validate([
            'fields' => [new fieldsMatch($service)],
        ]);


        Order::create([
            'service_id' => $request->service_id,
            'user_id' => $request->user()->id,
            'fields' => $request->fields,
            'status' => 'new'
        ]);
        return ['success' => 'تم تقديم الطلب'];
    }

    public function getProviderOrders(Request $request)
    {
        return $request->user()->Orders()->with(['service.offer'])->get();
    }

    public function resume(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer'
        ]);
        // $order = Order::find(1)->where(['id'=>$request->order_id,'status'=>'new'])->first();
        $order = $request->user()->Orders()->where(['orders.id' => $request->order_id, 'status' => 'new'])->first();

        if ($order) {
            $order->status = 'resumed';
            $order->save();
            return response(['success' => 'order successfully resumed']);
        }else
            return response(['failed' => 'there is no a new order that belongs to you with this id'],400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}