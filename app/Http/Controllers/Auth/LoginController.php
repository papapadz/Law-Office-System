<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Carbon;

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

     public function redirectTo()
    {
        /** updates the recent logins */
        if(auth()->user()) {
            User::where('id',auth()->user()->id)->update([
                'last_login' => Carbon\Carbon::now()->toDateTimeString()
            ]);
        }
       if (auth()->user()->role_id == 3) {
        return 'admin/dashboard';
       }
       elseif(auth()->user()->role_id == 2) {
        return '/user/query';
       }
       return 'home';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
