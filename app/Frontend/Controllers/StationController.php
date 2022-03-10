<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StationController extends Controller
{

    /**
     * getAll
     *
     * @return void
     */
    public function getAll()
    {
        $stations = Station::get();
        if ($stations) {
            return $this->response(Response::HTTP_OK, 'Get list station success', $stations, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list station fail', []);
    }

    public function listHardCodeSearch()
    {
        $stations = Station::whereIn('name', Station::HARD_CODE_STATION_SEARCH)->groupBy('name')->orderBy('name', 'DESC')->get();
        if ($stations) {
            return $this->response(Response::HTTP_OK, 'Get list station success', $stations, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list station fail', []);
    }
}
