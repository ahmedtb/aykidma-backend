<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\OffersController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ProviderAuthController;
use App\Http\Controllers\API\UserNotificationsController;

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
Route::get('userNotifications', [UserNotificationsController::class, 'index'])->middleware('auth:sanctum');


Route::post('/loginProvider', [ProviderAuthController::class, 'login']);
Route::delete('/logoutProvider', [ProviderAuthController::class, 'logout'])->middleware(['auth:sanctum','type.provider']);
Route::post('enrollProvider', [ProviderAuthController::class, 'enrollProvider']);
Route::get('provider', [ProviderAuthController::class, 'provider'])->middleware(['auth:sanctum','type.provider']);

Route::put('/approve/service', [AdminController::class, 'approveService'])->middleware(['auth:sanctum','type.admin']);

Route::resource('category', CategoryController::class);

Route::get('offers', [OffersController::class, 'allOffersWithApprovedServices']);
Route::get('offers/{category_id}', [OffersController::class, 'byCategory']);

Route::get('service/{offer_id}', [ServicesController::class, 'getOfferServices']);
Route::post('services', [ServicesController::class, 'create'])->middleware(['auth:sanctum','type.provider']);
Route::post('createServiceWithOffer', [ServicesController::class, 'createWithOffer'])->middleware(['auth:sanctum','type.provider']);

Route::get('myServices', [ServicesController::class,'myServices'])->middleware(['auth:sanctum','type.provider']);

Route::get('orders', [OrdersController::class, 'index'])->middleware('auth:sanctum');
Route::get('orders/{service_id}', [OrdersController::class, 'getServiceOrders'])->middleware('auth:sanctum');
Route::post('orders', [OrdersController::class, 'create'])->middleware('auth:sanctum');
Route::put('order/resume', [OrdersController::class, 'resume'] )->middleware(['auth:sanctum','type.provider']);
Route::put('order/done', [OrdersController::class, 'done'] )->middleware(['auth:sanctum']);
Route::get('providerOrders', [OrdersController::class, 'getProviderOrders'])->middleware(['auth:sanctum','type.provider']);

