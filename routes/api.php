<?php

use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\RegisterController;
use App\Frontend\Controllers\Auth\ResetPasswordController;
use App\Frontend\Controllers\Auth\LoginController;
use App\Frontend\Controllers\EstateController;
use App\Frontend\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', ]], function () {
    Route::middleware('auth:api')->group(function () {
        Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
    });
    Route::get('/verify/{token}', [VerificationController::class, 'verifyEmail'])->name('verify.email');
    Route::put('/login', [LoginController::class, 'getRefreshToken'])->name('refresh');
    Route::post('/register', [RegisterController::class, 'registerCustomer'])->name('customer.register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.check');
    Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('customer.forgotpassword');
    Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'resetPassword'])->name('customer.resetpassword');

});

Route::group(['prefix' => 'list'], function () {
    Route::post('/', [EstateController::class, 'search']);
});

Route::group(['prefix' => 'detail'], function () {
    Route::post('/', [EstateController::class, 'detail']);
});

Route::get('test_import_estates', function() {
    $estates = array();
    foreach (range(1, 11) as $number) {
        try{
            $estate_data = file_get_contents(base_path() . '/tests/data/estate' . $number . '.json');
            $estate = json_decode($estate_data, true);
            array_push($estates, $estate);
        } catch (Exception $e) {
        }
    }
    return response()->json(array('estates' => $estates));
});
