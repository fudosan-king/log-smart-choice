<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\SendEmailNoticeAdminAfterCustomerRegister;
use App\Models\Customer;
use App\Models\District;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Token;
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
        $customer = Customer::where('email', $request->email)->where('status', Customer::EMAIL_VERIFY)->first();

        if ($customer) {
            if ($customer->validateForPassportPasswordGrant($request->password)) {
                $objectToken = $this->_getAccessToken($customer);
                $data = [
                    'access_token'       => $objectToken->accessToken,
                    'token_type'         => 'Bearer',
                    'expires_at'         => Carbon::parse(
                        $objectToken->token->expires_at
                    )->toDateTimeString(),
                    'customer_name'      => $customer->name,
                    'customer_email'     => $customer->email,
                    'customer_social_id' => $customer->social_id,
                ];
                return $this->response(200, __('auth.login_success'), $data, true);
            }
            return $this->response(422, __('auth.password_or_email_wrong'));
        }
        return $this->response(422, __('auth.customer_not_found'));
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
        return $this->response(200, __('auth.logout_success'), [], true);
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
                $customer = Customer::where('social_id', $socialId)->where('status', Customer::ACTIVE)->first();
                $districts = District::select('name')
                    ->where('status', District::STATUS_ACTIVATE)
                    ->get()->toArray();
                $districtNew = [];
                foreach ($districts as $district) {
                    $districtNew[] = $district['name'];
                }
                $price = [
                    'min' => Customer::CONDITION_MIN,
                    'max' => Customer::CONDITION_MAX,
                ];
                $square = [
                    'min' => Customer::CONDITION_MIN,
                    'max' => Customer::CONDITION_MAX,
                ];

                $announcementCondition = [
                    'city' => $districtNew,
                    'price' => $price,
                    'square' => $square,
                ];
                if ($user->email) {
                    $customer = Customer::where('email', $user->email)->first();
                    if ($customer) {
                        $customer->status = Customer::EMAIL_VERIFY;
                        $customer->save();
                    }
                }

                if (!$customer) {
                    $customer = new Customer();
                    $customer->name = $user->name;
                    $customer->email = $user->email;
                    $customer->social_type = $socialType;
                    $customer->social_id = $socialId;
                    $customer->role3d = Customer::ROLE_3D_CUSTOMER;
                    $customer->status = Customer::EMAIL_VERIFY;
                    $customer->send_announcement = Customer::SEND_ANNOUNCEMENT;
                    $customer->announcement_condition = json_encode($announcementCondition);
                    $customer->save();
                    $createdAtJPTime = date('Y-m-d H:i:s', strtotime('+9 hour', strtotime($customer->created_at)));
                    $this->_sendNoticeAdmin($customer, $createdAtJPTime);
                }

                $objectToken = $this->_getAccessToken($customer);

                $data = [
                    'access_token'       => $objectToken->accessToken,
                    'token_type'         => 'Bearer',
                    'expires_at'         => Carbon::parse(
                        $objectToken->token->expires_at
                    )->toDateTimeString(),
                    'customer_name'      => $customer->name,
                    'customer_email'     => $customer->email,
                    'customer_social_id' => $customer->social_id,
                ];
                
                return $this->response(200, __('auth.login_success'), $data, true);
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
        $customerToken = Token::where('user_id', $customer->id)->where('revoked', 0)->first();
        if ($customerToken) {
            $customerToken->revoked = 1;
            $customerToken->save();
        }
        $tokenResult = $customer->createToken('log-smart-choice');
        $token = $tokenResult->token;
        $token->save();
        return $tokenResult;
    }

    /**
     * Send email notice admin group
     * 
     */
    private function _sendNoticeAdmin(Customer $customer, $createdAt) {
        $data = [
            'customer' => $customer,
            'created_at' => $createdAt
        ];
        $emailNoticeAdmin = new SendEmailNoticeAdminAfterCustomerRegister(env('EMAIL_SEND_NOTICE_TO_ADMIN', ''), $customer);
        dispatch($emailNoticeAdmin);
    }
}
