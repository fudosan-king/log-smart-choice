<?php

use App\Frontend\Controllers\AnnouncementController;
use App\Frontend\Controllers\Auth\ConfirmPasswordController;
use Illuminate\Support\Facades\Route;
use App\Frontend\Controllers\Auth\RegisterController;
use App\Frontend\Controllers\Auth\ResetPasswordController;
use App\Frontend\Controllers\Auth\LoginController;
use App\Frontend\Controllers\EstateController;
use App\Frontend\Controllers\Auth\VerificationController;
use App\Frontend\Controllers\WishListController;
use App\Frontend\Controllers\CustomerController;
use App\Frontend\Controllers\StationController;

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


Route::middleware('auth:api')->group(function () {
    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');

    // WishList
    Route::post('/wishlist', [WishListController::class, 'upsertWishList'])->name('wishlist.add');
    Route::post('/wishlist/list', [WishListController::class, 'getWishLists'])->name('wishlist.list');

    // Customer
    Route::post('/customer', [CustomerController::class, 'getCustomer'])->name('customer.getInformation');
    Route::put('/customer', [CustomerController::class, 'update'])->name('customer.update');
    Route::put('/customer/announcement-condition', [CustomerController::class, 'updateAnnouncementCondition'])->name('customer.update.announcementCondition');

    // Confirm password
    Route::put('/confirm-password' ,[ConfirmPasswordController::class, 'updatePassword'])->name('customer.update.password');

    // Estate
    Route::post('/estate/estate-3d', [EstateController::class, 'updateEstateId3D'])->name('estate.updateIdEstate3D');

    // Annoucement
    Route::put('/announcement', [AnnouncementController::class, 'markRead'])->name('announcement.update.read');
    Route::delete('/announcement', [AnnouncementController::class, 'delete'])->name('announcement.delete');
    
});

// auth
Route::post('/verify', [VerificationController::class, 'verifyEmail'])->name('verify.email');
Route::post('/register', [RegisterController::class, 'registerCustomer'])->name('customer.register');
Route::post('/reconfirmation-email', [RegisterController::class, 'reconfirmEmail'])->name('customer.forgotpassword');
Route::post('/login', [LoginController::class, 'login'])->name('login.check');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('customer.forgotpassword');
Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'resetPassword'])->name('customer.resetpassword');


// register social network
Route::post('/google-login', [LoginController::class, 'socialLogin']);
Route::post('/facebook-login', [LoginController::class, 'socialLogin']);

// station
Route::get('/stations/list', [StationController::class, 'getAll']);


Route::group(['prefix' => 'list'], function () {
    Route::post('/', [EstateController::class, 'search']);
});

Route::group(['prefix' => 'detail'], function () {
    Route::post('/', [EstateController::class, 'detail']);
});

Route::get('test_import_estates', function () {
    $estates = array();
    foreach (range(1, 11) as $number) {
        try {
            $estate_data = file_get_contents(base_path() . '/tests/data/estate' . $number . '.json');
            $estate = json_decode($estate_data, true);
            array_push($estates, $estate);
        } catch (Exception $e) {
        }
    }
    return response()->json(array('estates' => $estates));
});
