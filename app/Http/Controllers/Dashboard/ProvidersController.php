<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;

class ProvidersController extends Controller
{
    public function show(Request $request, $id)
    {
        return ServiceProvider::where('id', $id)->first();
    }
}
