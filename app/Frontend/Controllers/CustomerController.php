<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getCustomer()
    {
        $customerId = auth()->guard('api')->user()->id;
        $customer = Customer::select('name', 'email', 'phone_number', 'role3d', 'social_id')
            ->where('id', $customerId)
            ->where('status', Customer::ACTIVE)
            ->first();
        if ($customer) {
            $customer->is_logged = Auth::check();
            $customer->role3d = Customer::ROLE3D[$customer->role3d];
            return $this->response(200, __('customer.customer_success'), $customer, true);
        }
        return $this->response(422, __('customer.customer_fail'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {

        $customerId = Auth::user()->id;
        $name = $request->get('name');
        $email = $request->get('email');
        $phoneNumber = $request->get('phone_number');
        $birthday = $request->get('birthday');


        $rule = [
            'name' => 'required',
            'email' => 'required|email',
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return $this->response(422, $validate->errors(), []);
        }

        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response(422, __('auth.email_invalid'), []);
            }
            $customer = Customer::where('email', $email)->where('id', '<>', $customerId)->first();
            if ($customer) {
                return $this->response(422, __('auth.email_already_exist'), []);
            }
        }

        if ($phoneNumber) {
            if (strlen($phoneNumber) != 10) {
                return $this->response(422, 'Invalid phone number format', []);
            }

            $patternPhoneNumber = '/^(?=.*[0-9])(?!.*[~!@#$%^&*()_+])(?!.*[a-zA-Z]).*$/';
            if (!preg_match($patternPhoneNumber, $phoneNumber)) {
                return $this->response(422, 'Invalid phone number format', []);
            }
        }

        if ($birthday) {
            if (!checkdate((int)$birthday['month'], (int)$birthday['day'], (int)$birthday['year'])) {
                return $this->response(422, 'Your birthday is invalid', []);
            }
            $birthday = (int)$birthday['year'] . '-' . (int)$birthday['month'] . '-' . (int)$birthday['day'];
        }

        try {
            $customer = Customer::find($customerId);
            $customer->name = $name ?? $customer->name;
            $customer->email =  $email ?? $customer->email;
            $customer->phone_number = $phoneNumber;
            $customer->birthday = $birthday ?: '';
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Customer update fail', []);
        }

        return $this->response(200, 'Customer update success', [], true);
    }

    /**
     * updateAnnouncementCondition
     *
     * @param  mixed $request
     * @return void
     */
    public function updateAnnouncementCondition(Request $request)
    {
        $customerId = Auth::user()->id;

        $city = $request->get('city');
        $price = $request->get('price');
        $square = $request->get('square');

        if ($price && $price['min'] > $price['max']) {
            return $this->response(422, 'Invalid price', []);
        }

        if ($square && $square['min'] > $square['max']) {
            return $this->response(422, 'Invalid square', []);
        }

        $data = [
            'city' => $city,
            'price' => $price,
            'square' => $square,
        ];

        try {
            $customer = Customer::find($customerId);
            $customer->announcement_condition = $data;
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Customer update announcement condition fail', []);
        }
        return $this->response(200, 'Customer update announcement condition success', [], true);
    }
}
