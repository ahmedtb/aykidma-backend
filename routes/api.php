<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProviderAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServicesController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('signup', [AuthController::class, 'signup']);
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::post('/loginProvider', [ProviderAuthController::class, 'login']);
Route::delete('/logoutProvider', [ProviderAuthController::class, 'logout'])->middleware(['auth:sanctum','type.provider']);
Route::post('enrollProvider', [ProviderAuthController::class, 'enrollProvider']);

Route::put('/approve/service', [AdminController::class, 'approveService'])->middleware(['auth:sanctum','type.admin']);


Route::get('offers', [OffersController::class, 'allOffers']);
// Route::post('offers', [OffersController::class, 'create'])->middleware(['auth:sanctum','type.provider']);

Route::get('service/{offer_id}', [ServicesController::class, 'getOfferServices']);
Route::post('services', [ServicesController::class, 'create'])->middleware(['auth:sanctum','type.provider']);
Route::post('createServiceWithOffer', [ServicesController::class, 'createWithOffer'])->middleware(['auth:sanctum','type.provider']);

Route::get('myServices', [ServicesController::class,'myServices'])->middleware(['auth:sanctum','type.provider']);

Route::get('orders', [OrdersController::class, 'index'])->middleware('auth:sanctum');
Route::get('orders/{service_id}', [OrdersController::class, 'getServiceOrders'])->middleware('auth:sanctum');
Route::post('orders', [OrdersController::class, 'create'])->middleware('auth:sanctum');
Route::put('order/resume', [OrdersController::class, 'resume'] )->middleware(['auth:sanctum','type.provider']);
Route::get('providerOrders', [OrdersController::class, 'getProviderOrders'])->middleware(['auth:sanctum','type.provider']);
