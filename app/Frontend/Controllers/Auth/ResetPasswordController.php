<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailResetPassword;
use App\Models\Customer;
use App\Models\ResetPassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
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
    public function forgotPassword(Request $request)
    {
        request()->validate(['email' => 'required|email']);

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            $link = Lang::get('auth.email_not_exist');
            return response()->json(['status' => false, 'message' => $link]);
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

        $link = url('api/customer/reset-password') . "/" . $resetPassword->token;

        $data = [
            'link' => $link,
            'customer' => $customer
        ];

        $emailResetPassword = new SendEmailResetPassword($request->only('email'), $data);
        dispatch($emailResetPassword);

        return response()->json(['status' => true, 'message' => 'We have e-mailed your password reset link!']);
    }

    /**
     *
     * Creat new password
     *
     * @param Request $request
     * @param $hash
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function newPassword(Request $request, $hash)
    {
        $validate = Validator::make($request->all(), [
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // Check password confirm
        if ($request->password == $request->password_confirmation) {
            // Check email with token
            $resetPassword = ResetPassword::where('token', $hash)->first();

            if ($resetPassword) {
                $timeCurrent = date('Y-m-d H:i:s');
                $timeVerify = date('Y-m-d H:i:s', strtotime($resetPassword->created_at) + Customer::TIME_VERIFY_ACCOUNT);

                if ($timeCurrent > $timeVerify) {
                    session()->flash('message', 'Expired activate your account');
                    return redirect()->route('login');
                }

                // Update new password
                $customer = Customer::where('email', $resetPassword->email)->first();
                $customer->password = bcrypt($request->password);
                $customer->save();

                // Delete token
                ResetPassword::where('email', $resetPassword->email)->delete();

                return redirect()->route('login');
            }
            return response()->json(['status' => false, 'message' => Lang::get('auth.link_check_token_password_fail')], 422);
        }
        return response()->json(['status' => false, 'message' => Lang::get('auth.password_not_match')], 422);
    }
}
