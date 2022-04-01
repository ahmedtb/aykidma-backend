<?php

namespace App\Http\Controllers\API;

use App\Models\User;

use App\Models\Admin;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Rules\ArrayOfFieldsRule;
use App\FieldsTypes\ArrayOfFields;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\MessageNotification;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class OrdersController extends Controller
{

    public function getServiceOrders(Request $request, $service_id)
    {
        // could be provider or a user...does not matter since both has orders() function
        return $request->user()->orders()->where('service_id', $service_id)->with(['service', 'service.ServiceProvider'])->get();
    }

    public function userOrders(Request $request)
    {
        $orders = $request->user('user')->orders()->with(['service', 'service.ServiceProvider'])->get();
        foreach ($orders as $order) {
            if ($order->status == 'resumed') {
                $order->service->makeVisible(['phone_number']);
            }
        }
        return $orders;
    }

    public function providerOrders(Request $request)
    {
        return $request->user()->orders('provider')->with(['service'])->get();
    }

    public function create(Request $request)
    {

        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::where('id', $request->service_id)->first();

        $request->validate([
            'array_of_fields' => ['required', new ArrayOfFieldsRule($service->array_of_fields)],
        ]);
        if ($request->user('user')->provider && $request->user('user')->provider->id == $service->ServiceProvider->id)
            throw ValidationException::withMessages(['user' => 'you can not submit to your service provider services!!']);


        Order::create([
            'service_id' => $request->service_id,
            'user_id' => $request->user('user')->id,
            'array_of_fields' => ArrayOfFields::fromArray($request->array_of_fields),
            'status' => 'new'
        ]);
        $service->ServiceProvider->notify(new MessageNotification('you have new order', 'order by: ' . $request->user('user')->id, 'provider'));

        return ['success' => 'تم تقديم الطلب'];
    }

    public function getProviderOrders(Request $request)
    {
        return $request->user()->Orders('provider')->with(['service'])->get();
    }

    public function resume(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer'
        ]);
        // $order = Order::find(1)->where(['id'=>$request->order_id,'status'=>'new'])->first();
        $order = $request->user('provider')->Orders()->where(['orders.id' => $request->order_id, 'status' => 'new'])->first();

        if ($order) {
            $order->status = 'resumed';
            $order->save();
            $order->user->notify(new MessageNotification('your order is accepted', 'order: ' . $order->id, 'user'));
            return response(['success' => 'order successfully resumed']);
        } else
            return response(['failed' => 'there is no a new order that belongs to you with this id'], 400);
    }

    public function done(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'comment' => 'sometimes|string',
            'rating' => 'sometimes|min:0|max:5'
        ]);
        $order = $request->user('user')->Orders()->where(['orders.id' => $request->order_id, 'status' => 'resumed'])->first();

        if ($order) {
            $order->status = 'done';
            if ($request->comment && $request->rating) {
                Review::create([
                    'user_id' => $request->user('user')->id,
                    'order_id' => $request->order_id,
                    'comment' => $request->comment,
                    'rating' => $request->rating,
                ]);
            }
            $order->provider->notify(new MessageNotification('your order is done by user', 'order: ' . $order->id, 'provider'));
            $order->save();
            return response(['success' => 'order successfully marked as done']);
        } else
            return response(['failed' => 'there is no a resumed order that belongs to you with this id'], 400);
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

    public function userDelete(Request $request, $id)
    {
        $user = $request->user('user');

        if ($user->orders()->where('id', $id)->delete())
            return ['success' => 'order: ' . $id . ' successfully deleted'];
    }

    public function providerDelete(Request $request, $id)
    {
        $user = $request->user('provider');
        // return $user;

        if ($user->orders()->where('orders.id', $id)->delete())
            return ['success' => 'order: ' . $id . ' successfully deleted'];
        else
            return response()->json(['failure' => 'order: ' . $id . ' failed to deleted'], 424);
    }

    public function adminDelete(Request $request, $id)
    {
        $user = $request->user('admin');

        if (Order::where('id', $id)->delete())
            return ['success' => 'order: ' . $id . ' successfully deleted'];
    }
}
