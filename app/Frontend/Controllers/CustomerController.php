<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(Request $request) {
        dd($request->all());
    }
}
