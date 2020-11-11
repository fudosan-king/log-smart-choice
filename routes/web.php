<?php

use App\Http\Controllers\RenovationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\GridController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/renovation', [RenovationController::class, 'index'])->name('admin.renovation.index');
    Route::get('/sale', [SaleController::class, 'index'])->name('admin.sale.index');
    Route::get('/about', [AboutController::class, 'index'])->name('admin.about.index');
    Route::get('/estate', [EstateController::class, 'index'])->name('admin.estate.index');
});