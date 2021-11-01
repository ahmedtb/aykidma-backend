<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('guest')->except(['logout', 'fetchAdmin']);
    }

    public function username()
    {
        return 'phone_number';
    }

    protected function credentials(Request $request)
    {
        $data = $request->only($this->username(), 'password');
        // $data['email_confirmed'] = 1;
        return $data;
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // dd($this->guard('admin'));
        return $this->guard('admin')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }
    public function fetchAdmin(Request $request)
    {
        if ($request->user('admin')) {
            $admin = $request->user('admin');
            // $admin->role = 'admin';
            return $admin;
        }

        return null;
    }
}
