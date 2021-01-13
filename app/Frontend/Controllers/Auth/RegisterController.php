<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailVerifyAccount;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Frontend\Controllers\Auth\LoginController;

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
    public function registerCustomer(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if ($validator->passes()) {
            if ($customer = $this->create($request->all())) {
                $link = url('customer/verify') . "/" . $customer->email_verification_token;
                $data = [
                    'link' => $link,
                    'customer' => $customer,
                ];
                try {
                    $emailVerifyAccount = new SendEmailVerifyAccount($request->only('email'), $data);
                    dispatch($emailVerifyAccount);
                    return response()->json(['status' => true, 'message' => Lang::get('customer.create_success')], 200);
                } catch (\Exception $ex) {
                    return response()->json(['status' => false, 'message' =>'send email fail'], 404);
                }

            }
        }
        return response()->json(['status' => false, 'message' => Lang::get('customer.create_fail')], 422);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'email.required' => Lang::get('auth.email_required'),
            'email.max' => Lang::get('auth.email_max_length'),
            'email.email' => Lang::get('auth.email_invalid'),
            'password.required' => Lang::get('auth.password_required'),
            'password.min' => Lang::get('auth.pass_word_min_length_include_alphabet'),
            'password.regex' => Lang::get('auth.pass_word_min_length_include_alphabet'),
            'password.confirmed' => 'Password không giống nhau',
        ];
        return Validator::make($data, [
            'name'                  => ['required', 'string'],
            'email'                 => ['required', 'string', 'email', 'max:100', 'unique:customers'],
            'password'              => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z|A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/'],
            'phone_number'          => ['numeric'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ], $messages);
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
        $customer->phone_number = $data['phone_number'];
        $customer->password = Hash::make($data['password']);
        $customer->remember_token = Str::random(10);
        $customer->email_verification_token = Str::random(32);
        $customer->save();

        return $customer;
    }
}
