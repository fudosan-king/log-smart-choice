<?php
namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller {

    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getCustomer() {
        $customerId = auth()->guard('api')->user()->id;
        $customer = Customer::select('name', 'email', 'phone_number', 'role3d')->where('id', $customerId)->get()->toArray();
        if ($customer) {
            $customer[0]['is_logged'] = Auth::check();
            return response()->json(['customer' => $customer[0]], 200);
        }
        return [];
    }
}
