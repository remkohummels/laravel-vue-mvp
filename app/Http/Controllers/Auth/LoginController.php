<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override default login function
    public function login(Request $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // check if restaurant login
        if (Restaurant::where('restaurant_id', $request->email)->first()) {
            if (Restaurant::where('restaurant_id', $request->email)->first()->password_required) {
                // validate login credentials
                $this->validate($request, [
                    'email' => 'required|string',
                    'password' => 'required|string',
                ]);
                // check if password_required is set to true
                if (Auth::guard('restaurant')->attempt(['restaurant_id' => $request->email, 'password' => $request->password], $request->has('remember-me'))) {
                    return $this->sendLoginResponse($request);
                }
            } else {
                // validate login credentials
                $this->validate($request, [
                    'email' => 'required|string',
                ]);
                // check if password_required is set to false
                if (Auth::guard('restaurant')->loginUsingId(Restaurant::where('restaurant_id', $request->email)->first()->id, $request->has('remember-me'))) {
                    return $this->sendLoginResponse($request);
                }
            }
        }

        // check if restaurant login
        if (Restaurant::where('email', $request->email)->first()) {
            if (Restaurant::where('email', $request->email)->first()->password_required) {
                // validate login credentials
                $this->validate($request, [
                    'email' => 'required|string',
                    'password' => 'required|string',
                ]);
                // check if password_required is set to true
                if (Auth::guard('restaurant')->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember-me'))) {
                    return $this->sendLoginResponse($request);
                }
            } else {
                // validate login credentials
                $this->validate($request, [
                    'email' => 'required|string',
                ]);
                // check if password_required is set to false
                if (Auth::guard('restaurant')->loginUsingId(Restaurant::where('email', $request->email)->first()->id, $request->has('remember-me'))) {
                    return $this->sendLoginResponse($request);
                }
            }
        }

        // check if admin login
        if (User::where('email', $request->email)->first()) {
            // check if user status is active
            if (User::where('email', $request->email)->first()->active) {
                // validate login credentials
                $this->validate($request, [
                    'email' => 'required|email',
                    'password' => 'required|string',
                ]);

                if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember-me'))) {
                    return $this->sendLoginResponse($request);
                }
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // Override default logout function
    public function logout(Request $request)
    {
        if (Auth::guard('restaurant')->check()) {
            Auth::guard('restaurant')->logout();
        } else if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
