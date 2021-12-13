<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

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
            return $this->response(200, 'Get list station success', $stations, true);
        }

        return $this->response(422, 'Get list station fail', []);
    }

}
