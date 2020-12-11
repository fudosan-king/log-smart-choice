<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Lang;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     *
     * Verify Email
     *
     * @param null $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail($token = null)
    {
        if ($token == null) {
            session()->flash('message', Lang::get('auth.token_null'));
            return redirect()->route('login');
        }

        $customer = Customer::where('email_verification_token', $token)->first();

        if ($customer) {
            $timeCurrent = date('Y-m-d H:i:s');
            $timeVerify = date('Y-m-d H:i:s', strtotime($customer->created_at) + Customer::TIME_VERIFY_ACCOUNT);

            if ($timeCurrent > $timeVerify) {
                session()->flash('message', Lang::get('customer.token_expired'));
                return redirect()->route('login');
            }

            $customer->status = Customer::EMAIL_VERIFY;
            $customer->email_verified_at = $timeCurrent;
            $customer->email_verification_token = '';
            $customer->save();

            session()->flash('message', Lang::get('customer.activate_account_success'));

            return redirect()->route('login');
        }

        session()->flash('message', Lang::get('customer.customer_not_found'));
        return redirect()->route('login');
    }
}
