<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\ProvidersController;


Route::post('/loginAdmin', [LoginController::class, 'login']);
Route::delete('/logoutAdmin', [LoginController::class, 'logout']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/fetchAdmin', [LoginController::class, 'fetchAdmin']);
    Route::put('/approve/service', [AdminController::class, 'approveService']);
    Route::delete('/reject/service', [AdminController::class, 'rejectService']);
    Route::get('/approve/providerEnrollment/{id}', [AdminController::class, 'approveProvider']);
    Route::get('/activateProvider/{id}', [AdminController::class, 'activateProvider']);
    Route::delete('/order/deleteReview', [AdminController::class, 'deleteReview']);
    Route::resource('category', CategoryController::class);
    Route::get('providers/{id}', [ProvidersController::class, 'show']);

    Route::get('orders', [OrdersController::class, 'index']);

});
