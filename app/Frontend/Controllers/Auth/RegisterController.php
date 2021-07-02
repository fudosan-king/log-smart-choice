<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendEmailVerifyAccount;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Register customer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerCustomer(RegisterRequest $request)
    {
        $params = [
            'name'                  => "User" . rand(0, 100000),
            'email'                 => $request->email,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation
        ];

        try {
            if ($customer = $this->create($params)) {
                $this->_sendActiveEmail($customer);
                return $this->response(200, __('customer.create_success'), [], true);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
        return $this->response(422, __('customer.create_fail'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\Customer
     */
    protected function create(array $data)
    {
        $customer = new Customer();
        $customer->name = $data['name'];
        $customer->email = $data['email'];
        // $customer->phone_number = $data['phone_number'];
        $customer->password = Hash::make($data['password']);
        $customer->remember_token = Str::random(10);
        $customer->role3d = Customer::ROLE_3D_CUSTOMER;
        $customer->email_verification_token = Str::random(32);
        $customer->has_password = true;
        $customer->save();

        return $customer;
    }

    /**
     * Reconfirm Email
     *
     * @param Request $request
     * @return void
     */
    public function reconfirmEmail(Request $request)
    {
        $email = $request->get('email');
        $rules = [
            'email' => 'required| string| email| max:100|',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'email.required' => __('auth.email_required'),
            'email.email'    => __('auth.email_invalid'),
        ]);

        if ($validator->fails()) {
            return $this->response(422, $validator->errors()->first());
        }

        $customer = Customer::where('email', $email)->where('status', Customer::DEACTIVE)->first();

        if (!$customer) {
            return $this->response(422, __('auth.email_not_exist'));
        }

        $this->_sendActiveEmail($customer);
        return $this->response(200, __('auth.reconfirm_email_success'), [], true);
    }

    /**
     * Send activate email
     *
     * @param Customer $customer
     * @return void
     */
    private function _sendActiveEmail(Customer $customer)
    {
        $link = url('customer') .'/'. $customer->email_verification_token . '/active-email';
        $data = [
            'link'     => $link,
            'customer' => $customer,
        ];

        $emailVerifyAccount = new SendEmailVerifyAccount($customer->email, $data);
        dispatch($emailVerifyAccount);
    }
}
