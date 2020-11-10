<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index() {
        return "here";
    }

    public function testController() {
        return view('admin.test');
    }
}
