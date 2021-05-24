<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $name = $request->get('name') ?? "User" . rand(0, 100000);
        $email = $request->get('email');
        $phoneNumber = $request->get('phone_number');
        $birthday = $request->get('birthday');


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
            if ($birthday['month'] < 0 || $birthday['month'] >  13) {
                return $this->response(422, 'Invalid month of birthday', []);
            }

            if ($birthday['month'] == 2) {
                if ($birthday['year'] % 4 == 0) {
                    if ($birthday['day'] > 29) {
                        return $this->response(422, 'Invalid day of birthday', []);
                    }
                } else {
                    if ($birthday['day'] > 28) {
                        return $this->response(422, 'Invalid day of birthday', []);
                    }
                }
            }

            if ($birthday['year'] < 1921) {
                return $this->response(422, 'Invalid year of birthday', []);
            }
        }

        try {
            $customer = Customer::find($customerId);
            $customer->name = $name;
            $customer->email = $email;
            $customer->phone_number = $phoneNumber;
            $customer->birthday = $birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day'];
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Customer update fail', []);
        }

        return $this->response(200, 'Customer update success', []);
    }
}
