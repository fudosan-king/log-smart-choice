<?php

use App\Http\Controllers\RenovationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\GroupEstateController;

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

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/{id}/estate/', [GroupEstateController::class, 'view'])->name('admin.groups.estate');
        Route::post('/{id}/estate/', [GroupEstateController::class, 'save'])->name('admin.groups.save');
    });

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('admin.about.index');
        Route::post('/', [AboutController::class, 'save'])->name('admin.about.save');
    });

    Route::group(['prefix' => 'estate'], function () {
        Route::get('/', [EstateController::class, 'index'])->name('voyager.estate.index');
        Route::put('/{id}/update', [EstateController::class, 'update'])->name('voyager.estate.update');
        Route::get('/{id}/edit', [EstateController::class, 'edit'])->name('voyager.estate.edit');
    });

});