<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceProvider;

class ServicesController extends Controller
{
    
    public function getOfferServices($offer_id)
    {
        $services = Service::where('offer_id',$offer_id)->with('ServiceProvider')->get();
        return $services;
    }
}
