<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    
    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {

        $district = District::select('id', 'name')->where('status', District::STATUS_ACTIVATE)->get();

        if ($district) {
            return $this->response(200, 'Get list district success', $district, true);
        }

        return $this->response(422, 'Get list district fail', []);
    }
}
