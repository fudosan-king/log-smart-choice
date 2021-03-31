<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as PPClient;
use Laravel\Socialite\Facades\Socialite;

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

    /**
     * Show form login
     *
     * @return string
     */
    public function showLoginForm()
    {
        return response()->json(["message" => "Please login before call api"], 404);
    }

    /**
     * Login
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            if ($customer->status == Customer::EMAIL_VERIFY) {
                if ($customer->validateForPassportPasswordGrant($request->password)) {
                    $client = $this->_getCustomerClient();
                    if ($client) {
                        return response()->json([
                            "message"       => "Success",
                            'client_id'     => $client->id,
                            'client_secret' => $client->secret,
                            'customer'      => $customer,
                        ], 200);
                    }
                }
                return $this->response('Email or password invalid', 'customer', 422, [__('auth.password_or_email_wrong')]);
            }
            return $this->response('Email invalid', 'customer', 422, [__('auth.email_not_activated')]);
        }
        return $this->response('Customer invalid', 'customer', 422, ['Customer does not exist']);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->response('Logout', 'customer', 200, ['You have been successfully logged out!']);
    }

    /**
     * Get customer client
     *
     * @return mixed
     */
    private function _getCustomerClient()
    {
        return PPClient::where('password_client', 1)->where('provider', 'customers')->first();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function googleLogin(Request $request)
    {
        try {

            $googleId = $request->get('googleId');
            $fullName = $request->get('fullName');
            $email = $request->get('email');

            // valid email exist
            $customerGoogle = Customer::where('email', $email)->first();

            if ($customerGoogle) {
                if (!$customerGoogle->social == "google") {
                    return $this->response('Google Login invalid', 'customer', 422, ['Email already exist, please use another one']);
                }
            } else {
                $customerGoogle = new Customer();
                $customerGoogle->name = $fullName;
                $customerGoogle->email = $email;
                $customerGoogle->social = 'google';
                $customerGoogle->password = Hash::make($googleId);
                $customerGoogle->role3d = 3;
                $customerGoogle->status = Customer::EMAIL_VERIFY;
                $customerGoogle->save();
            }

            $client = $this->_getCustomerClient();
            if ($client) {
                return response()->json([
                    "message"       => "Success",
                    'client_id'     => $client->id,
                    'client_secret' => $client->secret,
                    'customer'      => $customerGoogle,
                ], 200);
            }

            return $this->response('Client invalid', 'customer', 422, ['Login with client fail!']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
