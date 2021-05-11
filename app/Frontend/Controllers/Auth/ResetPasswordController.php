<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\SendEmailResetPassword;
use App\Models\Customer;
use App\Models\ResetPassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     *
     * Forgot password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ResetPasswordRequest $request)
    {
        $customer = Customer::where('email', $request->email)->where('status', Customer::ACTIVE)->first();

        if (!$customer) {
            return $this->response(422, __('auth.email_not_exist'));
        }

        // create or update if exists
        $resetPassword = ResetPassword::where('email', $request->email)->first();
        if ($resetPassword) {
            $resetPassword->token = Str::random(60);
            $resetPassword->created_at = date("Y-m-d H:i:s");
            $resetPassword->save();
        } else {
            $resetPassword = new ResetPassword();
            $resetPassword->email = $request->email;
            $resetPassword->token = Str::random(60);
            $resetPassword->created_at = date("Y-m-d H:i:s");
            $resetPassword->save();
        }

        $link = url('/reset-password') . "/" . $resetPassword->token;

        $data = [
            'link' => $link,
            'customer' => $customer
        ];

        $emailResetPassword = new SendEmailResetPassword($request->only('email'), $data);
        dispatch($emailResetPassword);
        return $this->response(200, __('auth.send_email_reset_link'), [],true);
    }

    /**
     *
     * Creat new password
     *
     * @param Request $request
     * @param $hash
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request, $hash)
    {
        // Check password confirm
        if ($request->password == $request->password_confirmation) {
            // Check email with token
            $resetPassword = ResetPassword::where('token', $hash)->first();

            if ($resetPassword) {
                $timeCurrent = date('Y-m-d H:i:s');
                $timeVerify = date('Y-m-d H:i:s', strtotime($resetPassword->created_at) + Customer::TIME_VERIFY_ACCOUNT);

                if ($timeCurrent > $timeVerify) {
                    return $this->response(422, __('auth.token_forgotpassword_expired'));
                }

                try {
                    // Update new password
                    $customer = Customer::where('email', $resetPassword->email)->first();
                    $customer->password = bcrypt($request->password);
                    $customer->save();

                    // Delete token
                    ResetPassword::where('email', $resetPassword->email)->delete();
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }

                return $this->response(200, __('auth.reset_password_success'), [], true);
            }
            return $this->response(422, __('auth.link_check_token_password_fail'));
        }
        return $this->response(422, __('auth.password_not_match'));
    }
}
