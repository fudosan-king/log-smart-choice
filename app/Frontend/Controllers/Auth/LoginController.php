<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as PPClient;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'showLoginForm', 'refreshToken']]);
    }

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
    public function login(Request $request)
    {
        $rule = [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];

        $messages = [
            'email.required'    => Lang::get('auth.email_required'),
            'email.max'         => Lang::get('auth.email_max_length'),
            'email.email'       => Lang::get('auth.email_invalid'),
            'password.required' => Lang::get('auth.password_required'),
        ];
        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 404);
        }

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
                            'customer' => $customer,
                        ], 200);
                    }
                }
                $response = ["message" => Lang::get('auth.password_or_email_wrong')];
                return response($response, 404);
            }
            $response = ["message" => Lang::get('auth.email_not_activated')];
            return response()->json($response, 404);
        }
        return response()->json(["message" => "Customer does not exist"], 200);
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
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response, 200);

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
     * @param $username
     * @param $password
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    private function _loginBasicAuth($username, $password)
    {
        $url = 'http://' . $username . ':' . $password . '@' . env('URL_WEB') . '/oauth/token';
        if (env('APP_ENV') != 'development') {
            $url = url('oauth/token');
        }
        return $url;
    }
}
