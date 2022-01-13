<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
        AuthenticatesUsers::logout as defaultLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/client-selection';

    /** @var App\Models\User */
    protected $userLoggingOut;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('enterpriseId')->only('showLoginForm');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'usemail' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        // return $request->only('usemail', 'password');
        return ['usemail' => $request->{$this->username()}, 'password' => $request->password, 'usstatus' => 0];
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->userLoggingOut = $request->user();

        return $this->defaultLogout($request);
    }
    
    protected function loggedOut(Request $request)
    {
        return redirect('/login?ent=' . $this->userLoggingOut->usenterpriseid);
    }

    public function username()
    {
        return 'usemail';
    }
}
