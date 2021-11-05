<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ServicesController extends Controller
{

    public function show(Request $request, $id)
    {

        return Service::where('id', $id)->with($request->with)->first();
    }
}
