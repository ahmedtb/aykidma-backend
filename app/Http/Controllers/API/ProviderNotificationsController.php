<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProviderNotification;
use Illuminate\Support\Facades\Auth;

class ProviderNotificationsController extends Controller
{
    public function index()
    {
        return Auth::user()->notifications()->get();
    }
}
