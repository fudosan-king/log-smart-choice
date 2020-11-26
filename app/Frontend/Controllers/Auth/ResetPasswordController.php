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

    public function getForgotPasswordCustomer(Request $request)
    {
        request()->validate(['email' => 'required|email']);

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $result = Customer::where('email', $request->email)->first();
        if (!$result) {
            $link = Lang::get('auth.email_not_exist');
            return response()->json(['status' => false, 'message' => $link]);
        }

        ResetPassword::firstOrCreate(['email' => $request->email, 'token' => Str::random(60), 'created_at' => date("Y-m-d H:i:s")]);

        $token = ResetPassword::where('email', $request->email)->first();
        $link = url('customer/reset-password') . "/" . $token->token;

        $data = [
            'link' => $link
        ];

        $emailResetPassword = new SendEmailResetPassword($request->only('email'), $data);
        dispatch($emailResetPassword);
        return response()->json(['status' => true, 'message' => $link]);
    }

    public function newPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // Check password confirm
        if ($request->password == $request->password_confirmation) {
            // Check email with token
            $result = ResetPassword::where('token', $request->token)->first();
            if ($result) {
                // Update new password 
                Customer::where('email', $result->email)->update(['password' => bcrypt($request->password)]);

                // Delete token
                ResetPassword::where('token', $request->token)->delete();

                return redirect()->route('login');
            }
            return response()->json(['status' => false, 'message' => Lang::get('auth.link_check_token_password_fail')], 422);
        }
        return response()->json(['status' => false, 'message' => Lang::get('auth.password_not_match')], 422);
    }
}
