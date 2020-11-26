<?php

use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\RegisterController;
use App\Frontend\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Frontend\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Frontend\Controllers\EstateController;

Auth::routes(['verify' => true]);

Route::post('/register', [RegisterController::class, 'registerCustomer']);

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::middleware(['guest'])->group(function () {

    Route::post('/forgot-password', [ResetPasswordController::class, 'getForgotPasswordCustomer'])->name('customer.forgotpassword');
    Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'newPassword'])->name('customer.newpassword');
    
});

Route::get("/estate/search", [EstateController::class, 'search'])->name('customer.estate.search');


