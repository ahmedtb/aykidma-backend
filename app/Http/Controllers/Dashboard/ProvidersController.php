<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\ServiceProviderFilters;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;

class ProvidersController extends Controller
{
    public function show(Request $request, $id)
    {
        return ServiceProvider::where('id', $id)->first();
    }
    public function index(Request $request, ServiceProviderFilters $filters)
    {
        return ServiceProvider::filter($filters)->with($request->with)->get();
    }
}
