<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DistrictController;
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

// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', [AppController::class, 'get'])
    ->where('any', '^(?!(api|admin))[\/\w\.-]*');


Route::group(['prefix' => 'admin'], function () {
    // overwrite store admin users
    Route::post('admin/users', ['uses' => 'UserControllers@store', 'as' => 'custom.users.store']);

    // District Import
    Route::group(['prefix' => 'district'], function () {
        Route::get('/import', [DistrictController::class, 'indexDistrictImport'])->name('admin.district.import.index');
        Route::post('/import', [DistrictController::class, 'importDistrict'])->name('admin.district.import');
    });
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
