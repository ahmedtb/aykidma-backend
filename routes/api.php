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
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:user');
Route::post('signup', [AuthController::class, 'signup']);
Route::get('user', [AuthController::class, 'user'])->middleware('auth:user');
Route::get('user/image', [AuthController::class, 'myImage'])->middleware('auth:user');
Route::post('user/edit', [AuthController::class, 'editProfile'])->middleware('auth:user');

Route::get('userNotifications', [UserNotificationsController::class, 'index'])->middleware('auth:user');
Route::get('userNotificationTest', function () {
    $user = App\Models\User::where('id', 1)->first();
    $user->notify(new App\Notifications\MessageNotification('title', 'body', 'user'));
    return 'notify success';
});

// Route::post('/loginProvider', [ProviderAuthController::class, 'login']);
// Route::delete('/logoutProvider', [ProviderAuthController::class, 'logout'])->middleware(['auth:provider']);
Route::post('enrollProvider', [ProviderAuthController::class, 'enrollProvider'])->middleware(['auth:user']);
Route::get('provider', [ProviderAuthController::class, 'provider'])->middleware(['auth:user']);
Route::get('provider/image', [ProviderAuthController::class, 'myImage'])->middleware('auth:user');
Route::post('provider/edit', [ProviderAuthController::class, 'editProfile'])->middleware('auth:user');

Route::get('providerNotifications', [ProviderNotificationsController::class, 'index'])->middleware(['auth:provider']);
Route::get('providerNotificationTest', function () {
    $user = App\Models\User::where('id', 2)->first();
    $user->notify(new App\Notifications\MessageNotification('titleP', 'bodyP', 'provider'));
    return 'notify success';
});

Route::put('/approve/service', [AdminController::class, 'approveService'])->middleware(['auth:admin']);

Route::resource('category', CategoryController::class);

Route::get('services', [ServicesController::class, 'allApprovedServices']);
Route::get('services/{category_id}', [ServicesController::class, 'byCategory']);
Route::post('services', [ServicesController::class, 'create'])->middleware(['auth:provider']);
Route::put('services/{id}', [ServicesController::class, 'edit'])->middleware(['auth:provider']);
Route::get('myServices', [ServicesController::class, 'myServices'])->middleware(['auth:provider']);

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
Route::delete('order/{id}', [OrdersController::class, 'adminDelete'])->middleware('auth:admin');

Route::get('search/services/{q}', [SearchesController::class, 'servicesSearch']);
Route::get('search/services/{category_id}/{q}', [SearchesController::class, 'servicesCategorySearch']);
Route::middleware(['auth:provider'])->group(function () {
    Route::get('provider/search/newOrders/{q}', [SearchesController::class, 'providerNewOrdersSearch']);
    Route::get('provider/search/resumedOrders/{q}', [SearchesController::class, 'providerResumedOrdersSearch']);
    Route::get('provider/search/doneOrders/{q}', [SearchesController::class, 'providerDoneOrdersSearch']);
});

Route::delete('order/deleteReview', [AdminController::class, 'deleteReview'])->middleware(['auth:admin']);
