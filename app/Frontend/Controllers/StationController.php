<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Station;

class StationController extends Controller
{

    public function getAll() {
        $stations = Station::get();
        return response()->json($stations);
    }
}