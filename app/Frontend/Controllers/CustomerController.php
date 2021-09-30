<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
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
        $customer = Customer::select(
            'name', 'last_name', 'email', 'phone_number',
            'role3d', 'social_id', 'birthday', 'land_line',
            'announcement_condition', 'has_password', 'send_announcement'
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
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $phoneNumber = $request->get('phone_number');
        $landLine = $request->get('land_line');
        $birthday = $request->get('birthday');
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
            return $this->response(422, $validate->errors(), []);
        }

        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response(422, __('auth.email_invalid'), []);
            }
            $customer = Customer::where('email', $email)->where('id', '<>', $customerId)->first();
            if ($customer) {
                return $this->response(422, ['email' => __('auth.email_already_exist')], []);
            }
        }

        // if ($phoneNumber) {
        //     if (strlen($phoneNumber) != 11) {
        //         return $this->response(422, ['phone_number' => [__('customer.phonenumber_invalid')]], []);
        //     }

        //     if (!preg_match($patternPhoneNumber, $phoneNumber)) {
        //         return $this->response(422, ['phone_number' => [__('customer.phonenumber_invalid')]], []);
        //     }
        // }

        if ($landLine) {
            if (strlen($landLine) != 11 && strlen($landLine) != 10) {
                return $this->response(422, ['land_line' => [__('customer.landline_invalid')]], []);
            }

            if (!preg_match($patternPhoneNumber, $landLine)) {
                return $this->response(422, ['land_line' => [__('customer.landline_invalid')]], []);
            }
        }

        // if ($birthday) {
        //     if (!checkdate((int)$birthday['month'], (int)$birthday['day'], (int)$birthday['year'])) {
        //         return $this->response(422, ['birthday' => [__('customer.birthday_invalid')]], []);
        //     }
        //     $birthday = (int)$birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day'];
        // }

        try {
            $customer = Customer::find($customerId);
            $customer->name = $name ?? $customer->name;
            $customer->last_name = $lastName;
            $customer->email =  $email ?? $customer->email;
            $customer->phone_number = $phoneNumber;
            $customer->land_line = $landLine;
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
            return $this->response(422, $validate->errors(), []);
        }


        if ($price['min'] == '上限なし' || $price['max'] == '下限なし') {
            return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
        }

        if ($square['min'] == '上限なし' || $square['max'] == '下限なし') {
            return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
        }

        if (($price['min'] != '下限なし' && $price['min'] != '上限なし') &&
        ($price['max'] != '下限なし' && $price['max'] != '上限なし')) {
            if ($price['min'] > $price['max']) {
                return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
            }
        } elseif ($price['min'] == '下限なし' && $price['max'] == '下限なし' ||
        $price['min'] == '上限なし' && $price['max'] == '上限なし') {
            return $this->response(422, ['price' => [__('customer.price_invalid')]], []);
        }

        if (($square['min'] != '下限なし' && $square['min'] != '上限なし') &&
        ($square['max'] != '下限なし' && $square['max'] != '上限なし')) {
            if ($square['min'] > $square['max']) {
                return $this->response(422, ['square' => [__('customer.square_invalid')]], []);
            }
        } elseif ($square['min'] == '下限なし' && $square['max'] == '下限なし' ||
        $square['min'] == '上限なし' && $square['max'] == '上限なし') {
            return $this->response(422, ['price' => [__('customer.square_invalid')]], []);
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
            $customer->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Customer update announcement condition fail', []);
        }
        return $this->response(200, 'Customer update announcement condition success', [], true);
    }
}
