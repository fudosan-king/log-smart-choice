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
use App\Frontend\Controllers\DistrictController;
use App\Frontend\Controllers\StationController;
use App\Models\Estates;

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
    Route::put('/confirm-password', [ConfirmPasswordController::class, 'updatePassword'])->name('customer.update.password');

    // Estate
    Route::post('/estate/estate-3d', [EstateController::class, 'updateEstateId3D'])->name('estate.updateIdEstate3D');

    // Annoucement
    Route::put('/announcement', [AnnouncementController::class, 'markRead'])->name('announcement.update.read');
    Route::delete('/announcement', [AnnouncementController::class, 'delete'])->name('announcement.delete');
    Route::post('/announcement/list', [AnnouncementController::class, 'listAnnouncement'])->name('announcement.list');

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
Route::post('/stations/list', [StationController::class, 'getAll'])->name('station.list');
Route::get('/stations/get-companies', [StationController::class, 'getTransportCompany'])->name('station.companies');
Route::get('/stations/getByCompany', [StationController::class, 'getByTransportCompany'])->name('station.bycompany');

// District
Route::post('/district/list', [DistrictController::class, 'list'])->name('district.list');

//estate
Route::group(['prefix' => 'list'], function () {
    Route::post('/', [EstateController::class, 'search']);
});

Route::group(['prefix' => 'detail'], function () {
    Route::post('/', [EstateController::class, 'detail']);
});

Route::post('/estate/near', [EstateController::class, 'getEstateNear'])->name('estate.near');

Route::post('/estate/recommend', [EstateController::class, 'getEstatesRecomment'])->name('estate.recommend');

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
    foreach ($estates as $estate) {
        $estateData = MongoDB\BSON\toPHP(MongoDB\BSON\fromJson(json_encode($estate)));
        // if (in_array($estateData->_id, $this->importedEstateIds)
        //     || in_array($estateData->_id, $this->failedImportedEstatesId)) {
        //     continue;
        // }
        try {
            $estate = new Estates();
            // add room type in after import into order-renove
            $estateData->room_type = $estateData->room_floor . $estateData->room_kind;
            $importedEstate = $estate->upsertFromFDKData($estateData);
// dd($importedEstate);
            // if ($importedEstate !== null) {
            //     array_push($this->importedEstateIds, $importedEstate->_id);
            // } else {
            //     array_push($this->failedImportedEstatesId, $estateData->_id);
            // }
        } catch (Exception $e) {
            \Log::error($e);
            // array_push($this->failedImportedEstatesId, $estateData->_id);
        }
    }
    return response()->json(array('estates' => $estates));
});

Route::get('/test', [AnnouncementController::class, 'testSendNotice'])->name('admin.announcement.store');
Route::get('/test-sendnotice', [AnnouncementController::class, 'testSendEmail'])->name('admin.announcement.send.email');