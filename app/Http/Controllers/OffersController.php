<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function allOffers() {
        $offers = Offer::all();
        return $offers;
    }
}
