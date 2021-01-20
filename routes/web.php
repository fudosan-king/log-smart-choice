<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use TCG\Voyager\Facades\Voyager;

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
    Voyager::routes();
});
