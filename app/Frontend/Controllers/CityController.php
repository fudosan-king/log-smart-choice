<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        $cities = City::with('districts')
            ->where('status', City::STATUS_ACTIVE)
            ->orderBy('id')
            ->get()->toArray();
        $cityNew = [];
        if ($cities) {
            foreach ($cities as $city) {
                $countStations = count($city['districts']);
                if ($countStations > 0) {
                    $cityNew[] = $city;
                }
            }
            return $this->response(Response::HTTP_OK, 'Get list district success', $cityNew, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list district fail', []);
    }
}
