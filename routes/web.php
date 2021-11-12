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

// Auth::routes();

Route::view('/dashboard','dashboard');
Route::view('/dashboard/{path}','dashboard')->where('path', '([A-z\d\-\/_.]+)?');

// Route::resource('category', CategoryController::class);

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