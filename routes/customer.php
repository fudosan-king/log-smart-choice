<?php

use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\LoginController;
use App\Frontend\Controllers\EstateController;
use App\Frontend\Controllers\Auth\VerificationController;

Route::get('/verify/{token}', [VerificationController::class, 'verifyEmail'])->name('verify.email');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::group(['prefix' => 'estate'], function () {
    Route::get("/search", [EstateController::class, 'search'])->name('customer.estate.search');
    Route::get("/{id}/detail", [EstateController::class, 'detail'])->name('customer.estate.detail');
});
