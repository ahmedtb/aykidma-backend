<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\OffersController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\SearchsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SearchesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\Auth\AuthController;
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
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('signup', [AuthController::class, 'signup']);
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::get('user/image', [AuthController::class, 'myImage'])->middleware('auth:sanctum');
Route::post('user/edit', [AuthController::class, 'editProfile'])->middleware('auth:sanctum');

Route::get('userNotifications', [UserNotificationsController::class, 'index'])->middleware('auth:sanctum');
Route::get('userNotificationTest', function () {
    $user = App\Models\User::where('id', 1)->first();
    $user->notify(new App\Notifications\MessageNotification('title', 'body', 'user'));
    return 'notify success';
});

Route::post('/loginProvider', [ProviderAuthController::class, 'login']);
Route::delete('/logoutProvider', [ProviderAuthController::class, 'logout'])->middleware(['auth:sanctum', 'type.provider']);
Route::post('enrollProvider', [ProviderAuthController::class, 'enrollProvider']);
Route::get('provider', [ProviderAuthController::class, 'provider'])->middleware(['auth:provider']);
Route::get('provider/image', [ProviderAuthController::class, 'myImage'])->middleware('auth:sanctum');
Route::post('provider/edit', [ProviderAuthController::class, 'editProfile'])->middleware('auth:sanctum');

Route::get('providerNotifications', [ProviderNotificationsController::class, 'index'])->middleware(['auth:sanctum', 'type.provider']);
Route::get('providerNotificationTest', function () {
    $provider = App\Models\ServiceProvider::where('id', 1)->first();
    $provider->notify(new App\Notifications\MessageNotification('titleP', 'bodyP', 'provider'));
    return 'notify success';
});

Route::put('/approve/service', [AdminController::class, 'approveService'])->middleware(['auth:sanctum', 'type.admin']);
Route::put('/approve/provider', [AdminController::class, 'approveProvider'])->middleware(['auth:admin']);

Route::resource('category', CategoryController::class);

Route::get('services', [ServicesController::class, 'allApprovedServices']);
Route::get('services/{category_id}', [ServicesController::class, 'byCategory']);
Route::post('services', [ServicesController::class, 'create'])->middleware(['auth:sanctum', 'type.provider']);
Route::put('services/{id}', [ServicesController::class, 'edit'])->middleware(['auth:sanctum', 'type.provider']);
Route::get('myServices', [ServicesController::class, 'myServices'])->middleware(['auth:sanctum', 'type.provider']);

Route::get('orders', [OrdersController::class, 'index'])->middleware('auth:sanctum');
Route::get('orders/{service_id}', [OrdersController::class, 'getServiceOrders'])->middleware('auth:sanctum');
Route::post('orders', [OrdersController::class, 'create'])->middleware('auth:sanctum');
Route::put('order/resume', [OrdersController::class, 'resume'])->middleware(['auth:sanctum', 'type.provider']);
Route::delete('order/deleteReview', [AdminController::class, 'deleteReview'])->middleware(['auth:sanctum', 'type.admin']);

Route::put('order/done', [OrdersController::class, 'done'])->middleware(['auth:sanctum']);
Route::put('order/editReview', [OrdersController::class, 'editReview'])->middleware(['auth:sanctum']);
Route::get('providerOrders', [OrdersController::class, 'getProviderOrders'])->middleware(['auth:sanctum', 'type.provider']);

Route::get('search/services/{q}', [SearchesController::class,'servicesSearch']);
Route::get('search/services/{category_id}/{q}', [SearchesController::class,'servicesCategorySearch']);
Route::middleware(['auth:sanctum', 'type.provider'])->group(function () {
    Route::get('provider/search/newOrders/{q}', [SearchesController::class,'providerNewOrdersSearch']);
    Route::get('provider/search/resumedOrders/{q}', [SearchesController::class,'providerResumedOrdersSearch']);
    Route::get('provider/search/doneOrders/{q}', [SearchesController::class,'providerDoneOrdersSearch']);
});