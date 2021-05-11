<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

    public function approveService(Request $request){
        $request->validate([
            'service_id' => 'required|integer'
        ]);
        $service = Service::where('id',$request->service_id)->first();
        if($service){
            if($service->approved){
                return response(['failure' => 'the service is already approved'],404);
            }
            $service->approved = true;
            $service->save();
            return response(['success' => 'the service has been approved']);
        }else{
            $error = ValidationException::withMessages([
                'service_id' => ['this service does not exist'],
             ]);
             throw $error;
        }

    }
}
