<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CustomerController extends Controller
{

    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getCustomer()
    {
        $customerId = auth()->guard('api')->user()->id;
        $customer = Customer::select(
            'name', 'last_name', 'email', 'phone_number',
            'role3d', 'social_id', 'birthday', 'land_line',
            'announcement_condition', 'has_password', 'send_announcement',
            'first_announcement'
            )
            ->where('id', $customerId)
            ->where('status', Customer::ACTIVE)
            ->first();
        $announcement = Announcement::where('customer_id', $customerId)->where('is_read', 0)->whereNull('deleted_at')->count();
        if ($customer) {
            $customer->is_logged = Auth::check();
            $customer->role3d = Customer::ROLE3D[$customer->role3d];
            $customer->announcement_condition = json_decode($customer->announcement_condition, true);
            $customer->announcement_count = $announcement;
            $customer->orderrenove_customer_id = $this->randomOrderRenoveCustomerId(10);
            return $this->response(Response::HTTP_OK, __('customer.customer_success'), $customer, true);
        } else {
            $customerCheck = Customer::select('status')->where('id', $customerId)->first();
            if ($customerCheck->status == Customer::DEACTIVE) {
                return $this->response(Response::HTTP_BAD_REQUEST, __('customer.customer_fail'));
            }
            return $this->response(Response::HTTP_BAD_REQUEST, __('customer.customer_fail'));
        }
        
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
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $landLine = $request->get('land_line');
        $patternPhoneNumber = '/^(?=\d).*$/';

        $rule = [
            'name'          => ['required','regex:/^(?!.*[!@#$%^&*(),.?":{}|<>])(?!.*\d).+$/'],
            'last_name'     => ['required','regex:/^(?!.*[!@#$%^&*(),.?":{}|<>])(?!.*\d).+$/'],
            'email'         => 'required|email',
        ];

        $messages = [
            'email.required'     => __('auth.email_required'),
            'email.email'        => __('auth.email_invalid'),
            'name.required'      => __('auth.name_required'),
            'name.regex'         => __('auth.name_validate'),
            'last_name.required' => __('auth.name_required'),
            'last_name.regex'    => __('auth.name_validate'),
        ];

        $validate = Validator::make($request->all(), $rule, $messages);

        if ($validate->fails()) {
            return $this->response(Response::HTTP_BAD_REQUEST, $validate->errors(), []);
        }

        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response(Response::HTTP_BAD_REQUEST, __('auth.email_invalid'), []);
            }
            $customer = Customer::where('email', $email)->where('id', '<>', $customerId)->first();
            if ($customer) {
                return $this->response(Response::HTTP_BAD_REQUEST, ['email' => __('auth.email_already_exist')], []);
            }
        }

        if ($landLine) {
            if (strlen($landLine) != 11 && strlen($landLine) != 10) {
                return $this->response(Response::HTTP_BAD_REQUEST, ['land_line' => [__('customer.landline_invalid')]], []);
            }

            if (!preg_match($patternPhoneNumber, $landLine)) {
                return $this->response(Response::HTTP_BAD_REQUEST, ['land_line' => [__('customer.landline_invalid')]], []);
            }
        }

        try {
            $customer = Customer::find($customerId);
            $customer->name = $name ?? $customer->name;
            $customer->last_name = $lastName;
            $customer->email =  $email ?? $customer->email;
            $customer->land_line = $landLine;
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(Response::HTTP_BAD_REQUEST, 'Customer update fail', []);
        }

        return $this->response(Response::HTTP_OK, 'Customer update success', [], true);
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
        $sendAnnouncement = $request->get('send_announcement');


        $rule = [
            'price'  => ['required'],
            'square' => ['required'],
        ];

        $messages = [
            'price.required' => __('customer.price_invalid'),
            'square.email' => __('customer.square_invalid'),
        ];

        $validate = Validator::make($request->all(), $rule, $messages);

        if ($validate->fails()) {
            return $this->response(Response::HTTP_BAD_REQUEST, $validate->errors(), []);
        }


        if ($price['min'] == Customer::CONDITION_MAX || $price['max'] == Customer::CONDITION_MIN) {
            return $this->response(Response::HTTP_BAD_REQUEST, ['price' => [__('customer.price_invalid')]], []);
        }

        if ($square['min'] == Customer::CONDITION_MAX || $square['max'] == Customer::CONDITION_MIN) {
            return $this->response(Response::HTTP_BAD_REQUEST, ['square' => [__('customer.square_invalid')]], []);
        }

        if (($price['min'] != Customer::CONDITION_MIN && $price['min'] != Customer::CONDITION_MAX) &&
        ($price['max'] != Customer::CONDITION_MIN && $price['max'] != Customer::CONDITION_MAX)) {
            if ($price['min'] > $price['max']) {
                return $this->response(Response::HTTP_BAD_REQUEST, ['price' => [__('customer.price_invalid')]], []);
            }
        } elseif ($price['min'] == Customer::CONDITION_MIN && $price['max'] == Customer::CONDITION_MIN ||
        $price['min'] == Customer::CONDITION_MAX && $price['max'] == Customer::CONDITION_MAX) {
            return $this->response(Response::HTTP_BAD_REQUEST, ['price' => [__('customer.price_invalid')]], []);
        }

        if (($square['min'] != Customer::CONDITION_MIN && $square['min'] != Customer::CONDITION_MAX) &&
        ($square['max'] != Customer::CONDITION_MIN && $square['max'] != Customer::CONDITION_MAX)) {
            if ($square['min'] > $square['max']) {
                return $this->response(Response::HTTP_BAD_REQUEST, ['square' => [__('customer.square_invalid')]], []);
            }
        } elseif ($square['min'] == Customer::CONDITION_MIN && $square['max'] == Customer::CONDITION_MIN ||
        $square['min'] == Customer::CONDITION_MAX && $square['max'] == Customer::CONDITION_MAX) {
            return $this->response(Response::HTTP_BAD_REQUEST, ['price' => [__('customer.square_invalid')]], []);
        }

        $data = [
            'city' => $city,
            'price' => $price,
            'square' => $square,
        ];

        try {
            $customer = Customer::find($customerId);
            $customer->announcement_condition = $data;
            $customer->send_announcement = $sendAnnouncement;
            $customer->first_announcement = Customer::FIRST_ANNOUNCEMENT;
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(Response::HTTP_BAD_REQUEST, 'Customer update announcement condition fail', []);
        }
        return $this->response(Response::HTTP_OK, 'Customer update announcement condition success', [], true);
    }

    private function randomOrderRenoveCustomerId($length = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($chars);
        $random = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $random .= $chars[rand(0, $charactersLength - 1 )];
        }
        return $random;
    }
}
