<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        $user = Auth::user();
        $user_type = $user->usertype;

        if ($user_type == 'admin') {
            session()->flash('success', 'Selamat datang kembali, Admin ' . $user->name);
            return '/admin';
        }

        if ($user_type == 'user') {
            session()->flash('success', 'Halo ' . $user->name . ', Anda berhasil masuk!');
            return '/user';
        }

        session()->flash('success', 'You are logged in!');
        return '/';
    }
}
