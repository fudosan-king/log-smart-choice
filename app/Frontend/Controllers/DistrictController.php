<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Response;

class DistrictController extends Controller
{

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list()
    {
        $district = District::select('id', 'code', 'name', 'count_estates', 'city_id')
            ->where('status', District::STATUS_ACTIVATE)
            ->where('count_estates', '>', District::INIT_CONTAIN_ESTATE)
            ->get();

        if ($district) {
            return $this->response(Response::HTTP_OK, 'Get list district success', $district, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list district fail', []);
    }
    
    /**
     * customerList
     *
     * @return void
     */
    public function customerList() {
        $district = District::select('id', 'code', 'name')
            ->where('status', District::STATUS_ACTIVATE)
            ->get();

        if ($district) {
            return $this->response(Response::HTTP_OK, 'Get list district success', $district, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list district fail', []);
    }
    
    /**
     * listHardCodeSearch
     *
     * @return void
     */
    public function listHardCodeSearch() {
        $districts = District::whereIn('name', District::HARD_CODE_DISTRICT_SEARCH)->distinct()->orderBy('name', 'DESC')->get();
        if ($districts) {
            return $this->response(Response::HTTP_OK, 'Get list district success', $districts, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list district fail', []);
    }
}
