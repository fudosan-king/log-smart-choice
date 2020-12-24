<?php

use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\LoginController;
use App\Frontend\Controllers\EstateController;
use App\Frontend\Controllers\Auth\VerificationController;


Route::get('/', function () {return '<a href=/customer/login>Login</a><br><a href=/customer/estates>Estates Page</a>';});
Route::get('/verify/{token}', [VerificationController::class, 'verifyEmail'])->name('verify.email');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::group(['prefix' => 'estates'], function () {
	Route::get('/', function () {return '<a href=/customer/estates/search>Search</a>';});
    Route::get('/search', [EstateController::class, 'search'])->name('customer.estates.search');
    Route::get('/detail/{id}', [EstateController::class, 'detail'])->name('customer.estates.detail');
});
