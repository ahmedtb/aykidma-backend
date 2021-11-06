<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{

    public function index(Request $request, UserFilters $filters)
    {
        // return $request->all();
        return User::filter($filters)->with($request->with)->get();
    }

    public function show(Request $request, $id)
    {

        return User::where('id', $id)->with($request->with)->first();
    }
}
