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

        if ($customer = $this->create($params)) {
            $link = url('customer/verify') . "/" . $customer->email_verification_token;
            $data = [
                'link'     => $link,
                'customer' => $customer,
            ];
            try {
                $emailVerifyAccount = new SendEmailVerifyAccount($request->only('email'), $data);
                dispatch($emailVerifyAccount);
                return $this->response('Customer register success', 'customer', 200, [__('customer.create_success')]);
            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
        return $this->response('Customer register fail', 'customer', 422, [__('customer.create_fail')]);
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
        $customer->role3d = 3;
        $customer->email_verification_token = Str::random(32);
        $customer->save();

        return $customer;
    }
}
