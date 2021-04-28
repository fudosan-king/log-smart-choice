<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                    $objectToken = $this->_getAccessToken($customer);
                    return response()->json([
                        'access_token'  => $objectToken->accessToken,
                        'token_type'    => 'Bearer',
                        'expires_at'    => Carbon::parse(
                            $objectToken->token->expires_at
                        )->toDateTimeString(),
                        'customer_name' => $customer->name,
                        'customer_email'=> $customer->email,
                        'customer_social_id' => $customer->social_id,
                    ]);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function socialLogin(Request $request)
    {
        try {
            $socialId = $request->get('socialId');
            $socialType = $request->get('socialType');
            $data = Socialite::driver($socialType);
            $token = $request->get('token');

            if ($user = $data->userFromToken($token)) {
                // check email exist
                $customer = Customer::where('email', $user->email)->where('status', Customer::ACTIVE)->first();

                if (!$customer) {
                    $customer = new Customer();
                    $customer->name = $user->name;
                    $customer->email = $user->email;
                    $customer->social_type = $socialType;
                    $customer->social_id = $socialId;
                    $customer->role3d = Customer::ROLE_3D_CUSTOMER;
                    $customer->status = Customer::EMAIL_VERIFY;
                    $customer->save();
                }

                $objectToken = $this->_getAccessToken($customer);

                return response()->json([
                    'access_token'  => $objectToken->accessToken,
                    'token_type'    => 'Bearer',
                    'expires_at'    => Carbon::parse(
                        $objectToken->token->expires_at
                    )->toDateTimeString(),
                    'customer_name' => $customer->name,
                    'customer_email'=> $customer->email,
                    'customer_social_id' => $customer->social_id,
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param $customer
     * @return mixed
     */
    private function _getAccessToken($customer)
    {
        $tokenResult = $customer->createToken('log-smart-choice-local');
        $token = $tokenResult->token;
        $token->save();
        return $tokenResult;
    }
}
