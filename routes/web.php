<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard',[App\Http\Controllers\Dashboard\AdminController::class,'listOfNotApprovedServices'])->middleware('auth:admin');
Route::get('/dashboard/{path}',[App\Http\Controllers\Dashboard\AdminController::class,'listOfNotApprovedServices'])->where('path', '([A-z\d\-\/_.]+)?')->middleware('auth:admin');

Route::put('approve/service', [App\Http\Controllers\Dashboard\AdminController::class,'approveService'])->middleware('auth:admin');
Route::delete('reject/service', [App\Http\Controllers\Dashboard\AdminController::class,'rejectService'])->middleware('auth:admin');
Route::get('/approve/providerEnrollment/{id}', [App\Http\Controllers\Dashboard\AdminController::class, 'approveProvider'])->middleware(['auth:admin']);
Route::get('/activateProvider/{id}', [App\Http\Controllers\Dashboard\AdminController::class, 'activateProvider'])->middleware(['auth:admin']);
Route::delete('order/deleteReview', [App\Http\Controllers\Dashboard\AdminController::class, 'deleteReview'])->middleware(['auth:admin']);

Route::resource('category', CategoryController::class);

Route::get('userNotificationTest', function () {
    $user = App\Models\User::where('id', 1)->first();
    $user->notify(new App\Notifications\MessageNotification('title', 'body', 'user'));
    return 'notify success';
});
Route::get('providerNotificationTest', function () {
    $user = App\Models\User::where('id', 2)->first();
    $user->notify(new App\Notifications\MessageNotification('titleP', 'bodyP', 'provider'));
    return 'notify success';
});