<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\ServiceFilters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ServicesController extends Controller
{

    public function index(Request $request, ServiceFilters $filters)
    {
        // return $request->all();
        return Service::filter($filters)->with($request->with)->get();
    }

    public function show(Request $request, $id)
    {

        return Service::where('id', $id)->with($request->with)->first();
    }
}
