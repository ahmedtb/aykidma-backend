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
Route::put('approve/service', [App\Http\Controllers\Dashboard\AdminController::class,'approveService'])->middleware('auth:admin');
Route::delete('reject/service', [App\Http\Controllers\Dashboard\AdminController::class,'rejectService'])->middleware('auth:admin');

Route::resource('category', CategoryController::class);

// Route::get('adminLogin',function () {
//     return view('adminLogin');
// });
// Route::post('adminLogin',[App\Http\Controllers\Dashboard\LoginController::class,'login'])->name('adminLogin');
// Route::post('adminLogout',[App\Http\Controllers\Dashboard\LoginController::class,'logout']);

// Route::get('adminOnly',function () {
//     return 'admins only';
// })->middleware('auth:admin');