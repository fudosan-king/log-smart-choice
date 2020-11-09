<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MongoController as Controller;
use App\Block\Grid as Grid;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function index(Request $request)
    {
       return parent::index($request);
    }
}
