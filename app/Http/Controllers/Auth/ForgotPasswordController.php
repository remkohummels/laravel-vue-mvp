<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        if (Restaurant::where('restaurant_id', $request->email)->first()) {
            $restaurant = Restaurant::where('restaurant_id', $request->email)->first();
            $restaurant->remember_token = $request->_token;
            $email = $restaurant->email;
            $token = $request->_token;

            $restaurant->save();
        } else if (Restaurant::where('email', $request->email)->first()) {
            $restaurant = Restaurant::where('email', $request->email)->first();
            $restaurant->remember_token = $request->_token;
            $email = $restaurant->email;
            $token = $request->_token;

            $restaurant->save();
        } if (User::where('email', $request->email)->first()) {
            $user = User::where('email', $request->email)->first();
            $user->remember_token = $request->_token;
            $email = $user->email;
            $token = $request->_token;

            $user->save();
        }

        if (isset($email)) {

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            $data = [
                'email' => $email,
                'token' => $token,
            ];
            // need to show to the user. Finally, we'll send out a proper response.
            Mail::send('emails.resetpassword', $data, function ($mail) use ($data) {

                $mail->from('support@freadynow.com', 'FreadyNow');
                $mail->to($data['email'])->subject('FreadyNow');
            });

            return back()->with('status', 'Success');
        } else {
            return back()->with('status', 'Fail');
        }
    }
}
