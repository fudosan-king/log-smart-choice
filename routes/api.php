<?php

use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\RegisterController;
use App\Frontend\Controllers\Auth\ResetPasswordController;
use App\Frontend\Controllers\Auth\LoginController;

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

Route::group(['middleware' => ['cors', 'json.response'], 'prefix' => 'customer'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::post('/refresh', [LoginController::class, 'getRefreshToken'])->name('refresh');
    Route::post('/register', [RegisterController::class, 'registerCustomer'])->name('customer.register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.check');
    Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('customer.forgotpassword');
    Route::get('/reset-password/{hash}', [ResetPasswordController::class, 'showFormResetPassword'])->name('customer.form.resetpassword');
    Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'newPassword'])->name('customer.resetpassword');

});