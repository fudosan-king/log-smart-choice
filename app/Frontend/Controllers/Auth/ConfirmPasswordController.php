<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        $this->middleware('auth');
    }

    public function updatePassword(Request $request)
    {

        $customerId = Auth::user()->id;
        $rules = [
            'password'              => ['required', 'string', ' min:8', 'confirmed', 'regex:/^(?=.*[A-Z]|[a-z])(?=.*\d).+$/'],
            'password_confirmation' => 'required|string|min:8',
        ];

        $messages = [
            'password.required'  => __('auth.password_required'),
            'password.min'       => __('auth.pass_word_min_length_include_alphabet'),
            'password.regex'     => __('auth.pass_word_min_length_include_alphabet'),
            'password.confirmed' => __('auth.password_not_match'),
            'password.required'  => __('auth.password_required'),
            'password_confirmation' => __('auth.pass_word_min_length_include_alphabet'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->response(422, $validator->errors(), []);
        }

        try {
            $customer = Customer::find($customerId);
            $customer->password = bcrypt($request->password);
            $customer->has_password = true;
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, __('auth.update_password_fail'), []);
        }

        return $this->response(200, __('auth.update_password_success'), [], true);
    }
}
