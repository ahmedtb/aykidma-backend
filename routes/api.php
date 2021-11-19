<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\ReportsController;
use App\Http\Controllers\API\ReviewsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SearchesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\ProvidersController;
use App\Http\Controllers\API\Auth\ProviderAuthController;
use App\Http\Controllers\API\UserNotificationsController;
use App\Http\Controllers\API\ProviderNotificationsController;

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
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:user');
Route::post('signup', [AuthController::class, 'signup']);
Route::get('user', [AuthController::class, 'user'])->middleware('auth:user');
Route::get('user/image', [AuthController::class, 'myImage'])->middleware('auth:user');
Route::post('user/edit', [AuthController::class, 'editProfile'])->middleware('auth:user');

Route::post('enrollProvider', [ProviderAuthController::class, 'enrollProvider'])->middleware(['auth:user']);
Route::get('provider', [ProviderAuthController::class, 'provider'])->middleware(['auth:user']);
Route::get('provider/image', [ProviderAuthController::class, 'myImage'])->middleware('auth:user');
Route::post('provider/edit', [ProviderAuthController::class, 'editProfile'])->middleware('auth:provider');

Route::get('userNotifications', [UserNotificationsController::class, 'index'])->middleware('auth:user');
Route::get('providerNotifications', [ProviderNotificationsController::class, 'index'])->middleware(['auth:provider']);

Route::resource('category', CategoryController::class);

Route::get('services', [ServicesController::class, 'allApprovedServices']);

Route::get('services/{category_id}', [ServicesController::class, 'byCategory']);
Route::post('services', [ServicesController::class, 'create'])->middleware(['auth:provider']);
Route::put('services/{id}', [ServicesController::class, 'edit'])->middleware(['auth:provider']);
Route::get('myServices', [ServicesController::class, 'myServices'])->middleware(['auth:provider']);
Route::get('service/{id}/PhoneNumber', [ServicesController::class, 'showPhoneNumber'])->middleware(['auth:user']);

Route::get('provider/{id}', [ProvidersController::class, 'showActivated']);
Route::get('provider/{id}/services/', [ProvidersController::class, 'providerApprovedServices']);
Route::get('provider/{id}/image/', [ProvidersController::class, 'fetchImage']);

Route::get('service/{id}/reviews', [ReviewsController::class, 'fetchReviews']);

Route::get('userOrders', [OrdersController::class, 'userOrders'])->middleware('auth:user');
Route::get('providerOrders', [OrdersController::class, 'providerOrders'])->middleware('auth:provider');

Route::get('orders/{service_id}', [OrdersController::class, 'getServiceOrders'])->middleware('auth:user');
Route::post('orders', [OrdersController::class, 'create'])->middleware('auth:user');
Route::put('order/resume', [OrdersController::class, 'resume'])->middleware(['auth:provider']);

Route::put('order/done', [OrdersController::class, 'done'])->middleware(['auth:user']);
Route::put('order/editReview', [OrdersController::class, 'editReview'])->middleware(['auth:user']);
Route::get('providerOrders', [OrdersController::class, 'getProviderOrders'])->middleware(['auth:provider']);
Route::delete('userOrder/{id}', [OrdersController::class, 'userDelete'])->middleware('auth:user');
Route::delete('providerOrder/{id}', [OrdersController::class, 'providerDelete'])->middleware('auth:provider');
Route::delete('order/{id}', [OrdersController::class, 'adminDelete']);

Route::get('search/services/{q}', [SearchesController::class, 'servicesSearch']);
Route::get('search/services/{category_id}/{q}', [SearchesController::class, 'servicesCategorySearch']);
Route::middleware(['auth:provider'])->group(function () {
    Route::get('provider/search/newOrders/{q}', [SearchesController::class, 'providerNewOrdersSearch']);
    Route::get('provider/search/resumedOrders/{q}', [SearchesController::class, 'providerResumedOrdersSearch']);
    Route::get('provider/search/doneOrders/{q}', [SearchesController::class, 'providerDoneOrdersSearch']);
});

Route::post('reportReview', [ReportsController::class, 'reportReview']);
Route::post('reportSP', [ReportsController::class, 'reportSP']);
Route::post('reportService', [ReportsController::class, 'reportService']);


