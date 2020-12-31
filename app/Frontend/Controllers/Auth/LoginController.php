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
        // $obj = ['customers'=> array('full_name'=> 'phong hai', 'estate_detail'=> 'landmark')];
        // return view('auth.login',$obj);
        return 'đã login thành công';
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
            'email.required' => Lang::get('auth.email_required'),
            'email.max' => Lang::get('auth.email_max_length'),
            'email.email' => Lang::get('auth.email_invalid'),
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
                        return $this->getAccessToken($client, request('email'), request('password'), $customer);
                    }
                } else {
                    $response = ["message" => Lang::get('auth.password_or_email_wrong')];
                    return response($response, 404);
                }
            } else {
                $response = ["message" => Lang::get('auth.email_not_activated')];
                return response()->json($response, 404);
            }
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
     * Get access token
     *
     * @param PPClient $client
     * @param $email
     * @param $password
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccessToken(PPClient $client, $email, $password, $customer)
    {
        $response = Http::asForm()->post(url('oauth/token'), [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $email,
            'password'      => $password,
            'scope'         => '*',
        ]);
        $result = json_decode((string)$response->getBody(), true);

        $result['customer'] = $customer;
        return response()->json($result, 200);
    }

    /**
     * Get refresh token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getRefreshToken(Request $request)
    {
        $refreshToken = $request->header('Refreshtoken');
        $client = $this->_getCustomerClient();

        try {
            if ($client) {
                $response = Http::asForm()->post(url('oauth/token'), [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id'     => $client->id,
                    'client_secret' => $client->secret,
                    'scope'         => '*',
                ]);
                $customer = $request->user();
                $result = json_decode((string)$response->getBody(), true);
                $result['customer'] = $customer;
                return $result;
            }
        } catch (\Exception $e) {
            return response()->json("unauthorized", 401);
        }
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
}
