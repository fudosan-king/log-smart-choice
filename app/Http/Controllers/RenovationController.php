<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RenovationController extends Controller
{

    public function index() {
        return "here";
    }

    public function testController() {
        return view('renovation.test');
    }
}
