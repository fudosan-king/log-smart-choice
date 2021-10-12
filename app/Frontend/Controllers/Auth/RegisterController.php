<?php

namespace App\Frontend\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendEmailVerifyAccount;
use App\Models\Customer;
use App\Models\District;
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

        $announcement_condition = [
            'city' => $districtNew,
            'price' => $price,
            'square' => $square,
        ];
        $params = [
            // 'name'                  => "User" . rand(0, 100000),
            'name'                   => $request->name,
            'last_name'              => $request->last_name,
            'email'                  => $request->email,
            'password'               => $request->password,
            'announcement_condition' => $announcement_condition,
            'send_announcement'     => Customer::SEND_ANNOUNCEMENT,
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
        $customer->last_name = $data['last_name'];
        $customer->email = $data['email'];
        if ($data['land_line']) {
            $customer->land_line =$data['land_line'];
        }
        $customer->password = Hash::make($data['password']);
        $customer->remember_token = Str::random(10);
        $customer->role3d = Customer::ROLE_3D_CUSTOMER;
        $customer->email_verification_token = Str::random(32);
        $customer->has_password = true;
        $customer->send_announcement = $data['send_announcement'];
        $customer->announcement_condition = json_encode($data['announcement_condition']);
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

        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return $this->response(422, __('auth.email_not_exist'));
        }

        if ($customer->status == Customer::ACTIVE) {
            return $this->response(422, __('auth.email_has_active'));
        }

        $customer->created_at = date('Y-m-d H:i:s');
        $customer->save();

        $this->_sendActiveEmail($customer);
        return $this->response(200, __('auth.reconfirm_email_success'), [], true);
    }

    public function fastRegisterCustomer(Request $request) {

        $city = $request->get('city');
        $price = $request->get('price');
        $square = $request->get('square');
        $landLine = $request->get('land_line');
        $patternPhoneNumber = '/^(?=\d).*$/';

        $rules = [
            'name'                  => ['required','regex:/^(?!.*[!@#$%^&*(),.?":{}|<>])(?!.*\d).+$/'],
            'last_name'             => ['required','regex:/^(?!.*[!@#$%^&*(),.?":{}|<>])(?!.*\d).+$/'],
            'email'                 => 'required| string| email| max:100| unique:customers',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'email.required'     => __('auth.email_required'),
            'email.max'          => __('auth.email_max_length'),
            'email.email'        => __('auth.email_invalid'),
            'email.unique'       => __('auth.email_already_exist'),
            'name.required'      => __('auth.name_required'),
            'name.regex'         => __('auth.name_validate'),
            'last_name.required' => __('auth.name_required'),
            'last_name.regex'    => __('auth.name_validate'),
        ]);

        if ($validator->fails()) {
            return $this->response(422, $validator->errors());
        }

        if ($landLine) {
            if (strlen($landLine) != 11 && strlen($landLine) != 10) {
                return $this->response(422, ['land_line' => [__('customer.landline_invalid')]], []);
            }

            if (!preg_match($patternPhoneNumber, $landLine)) {
                return $this->response(422, ['land_line' => [__('customer.landline_invalid')]], []);
            }
        }

        if (!$price) {
            return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
        }

        if ($price['min'] == Customer::CONDITION_MAX || $price['max'] == Customer::CONDITION_MIN) {
            return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
        }

        if ($square['min'] == Customer::CONDITION_MAX || $square['max'] == Customer::CONDITION_MIN) {
            return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
        }

        if (($price['min'] != Customer::CONDITION_MIN && $price['min'] != Customer::CONDITION_MAX) &&
        ($price['max'] != Customer::CONDITION_MIN && $price['max'] != Customer::CONDITION_MAX)) {
            if ($price['min'] > $price['max']) {
                return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
            }
        } elseif ($price['min'] == Customer::CONDITION_MIN && $price['max'] == Customer::CONDITION_MIN ||
        $price['min'] == Customer::CONDITION_MAX && $price['max'] == Customer::CONDITION_MAX) {
            return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
        }

        if (!$square) {
            return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
        }

        if (($square['min'] != Customer::CONDITION_MIN && $square['min'] != Customer::CONDITION_MAX) &&
        ($square['max'] != Customer::CONDITION_MIN && $square['max'] != Customer::CONDITION_MAX)) {
            if ($square['min'] > $square['max']) {
                return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
            }
        } elseif ($square['min'] == Customer::CONDITION_MIN && $square['max'] == Customer::CONDITION_MIN ||
        $square['min'] == Customer::CONDITION_MAX && $square['max'] == Customer::CONDITION_MAX) {
            return $this->response(422, ['price' => [__('customer.square_invalid')]], []);
        }

        $announcement_condition = [
            'city' => $city,
            'price' => $price,
            'square' => $square,
        ];
        $params = [
            'name'                   => $request->name,
            'last_name'              => $request->last_name,
            'email'                  => $request->email,
            'password'               => Customer::PASSWORD_DEFAULT,
            'land_line'             => $request->land_line,
            'send_announcement'     => $request->send_announcement,
            'announcement_condition' => $announcement_condition,
        ];

        try {
            if ($customer = $this->create($params)) {
                $this->_sendActiveEmail($customer, true);
                return $this->response(200, __('customer.create_success'), [], true);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
        return $this->response(422, __('customer.create_fail'));
    }

    /**
     * Send activate email
     *
     * @param Customer $customer
     * @return void
     */
    private function _sendActiveEmail(Customer $customer, $fastRegister = false)
    {
        $link = url('customer') .'/'. $customer->email_verification_token . '/active-email';
        $data = [
            'link'     => $link,
            'customer' => $customer,
        ];
        if ($fastRegister) {
            $data['password_default'] = Customer::PASSWORD_DEFAULT;
        }

        $emailVerifyAccount = new SendEmailVerifyAccount($customer->email, $data);
        dispatch($emailVerifyAccount);
    }
}
