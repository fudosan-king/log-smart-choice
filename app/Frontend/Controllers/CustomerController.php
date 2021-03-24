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
        $customer = Customer::select('name', 'email', 'phone_number', 'role3d')->where('id', $customerId)->first();
        if ($customer) {
            $customer->is_logged = Auth::check();
            $customer->role3d = isset(Customer::ROLE[$customer->role3d]) ? Customer::ROLE[$customer->role3d] : null;
            return response()->json(['customer' => $customer], 200);
        }
        return [];
    }
}
