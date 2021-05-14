<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailResetPassword;
use App\Jobs\SendMailConfirmAccount;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
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
        // $this->middleware('signed')->only('verify');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     *
     * Verify Email
     *
     * @param null $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request)
    {
        $token = $request->get('token');
        if ($token == null) {
            return $this->response(422, __('auth.token_null'));
        }

        $customer = Customer::where('email_verification_token', $token)->first();

        if ($customer) {
            $timeCurrent = date('Y-m-d H:i:s');
            $timeVerify = date('Y-m-d H:i:s', strtotime($customer->created_at) + Customer::TIME_VERIFY_ACCOUNT);

            if ($timeCurrent > $timeVerify) {
                return $this->response(422, __('customer.token_expired'));
            }

            $customer->status = Customer::EMAIL_VERIFY;
            $customer->email_verified_at = $timeCurrent;
            $customer->email_verification_token = '';
            $customer->save();

            $data = [
                'customer' => $customer,
            ];

            $emailConfirmAccount = new SendMailConfirmAccount($customer->email, $data);
            dispatch($emailConfirmAccount);
            return $this->response(200, __('customer.activate_account_success'), [],true);
        }
        return $this->response(422, __('customer.activate_account_fail'));
    }
}
