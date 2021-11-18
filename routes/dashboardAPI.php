<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\ProvidersController;
use App\Http\Controllers\Dashboard\ServicesController;
use App\Http\Controllers\Dashboard\UsersController;

Route::post('/loginAdmin', [LoginController::class, 'login']);
Route::delete('/logoutAdmin', [LoginController::class, 'logout']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/fetchAdmin', [LoginController::class, 'fetchAdmin']);

    Route::get('/home', [HomeController::class, 'home']);

    Route::resource('category', CategoryController::class);

    Route::get('providers/{id}', [ProvidersController::class, 'show']);
    Route::get('providers', [ProvidersController::class, 'index']);
    Route::get('providerEnrollmentRequests', [ProvidersController::class, 'enrollmentRequest']);
    
    Route::get('/approve/providerEnrollment/{id}', [ProvidersController::class, 'approveProviderEnrollment']);
    Route::delete('/reject/providerEnrollment/{id}', [ProvidersController::class, 'rejectProviderEnrollment']);

    Route::get('/activateProvider/{id}', [ProvidersController::class, 'activateProvider']);

    Route::get('orders', [OrdersController::class, 'index']);
    Route::get('reviews/', [OrdersController::class, 'reviewsIndex']);
    Route::delete('/order/deleteReview', [OrdersController::class, 'deleteReview']);

    Route::put('/approve/service', [ServicesController::class, 'approveService']);
    Route::delete('/reject/service', [ServicesController::class, 'rejectService']);
    Route::get('services/{id}', [ServicesController::class, 'show']);
    Route::get('services/', [ServicesController::class, 'index']);

    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::get('users/', [UsersController::class, 'index']);
    Route::get('userNotifications', [UsersController::class, 'notifications']);
});
