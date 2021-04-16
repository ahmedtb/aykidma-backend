<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServicesController;
use App\Models\ServiceProvider;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class,'login']);
Route::delete('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum'); 
Route::post('signup',[AuthController::class, 'signup']);
Route::post('enrollProvider',[AuthController::class, 'enrollProvider']);



Route::get('user', [AuthController::class,'user'])->middleware('auth:sanctum');

Route::get('offers', [OffersController::class,'allOffers']);

Route::get('service/{offer_id}', [ServicesController::class,'getOfferServices']);
Route::post('services', [ServicesController::class,'create']);

Route::get('orders', [OrdersController::class,'index']);
Route::get('orders/{service_id}', [OrdersController::class,'getServiceOrders']);
Route::post('orders', [OrdersController::class,'create'])->middleware('auth:sanctum');

