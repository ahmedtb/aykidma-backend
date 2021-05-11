<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
     use AuthenticatesUsers;

     protected $redirectTo = RouteServiceProvider::HOME;


      public function __construct()
      {
          $this->middleware('guest')->except('logout');
      }

      public function login(Request $request)
    {
              $this->validate($request, [
                  'email' => 'required|email',
                  'password' => 'required',
              ]);
              if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                  return redirect('*your route*');
              } else {
                  dd('your username and password are wrong.');
              }
    }

      public function getLogin()
      {
          return view('*the login form*');
      }
}
