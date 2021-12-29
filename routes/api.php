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
use App\Frontend\Controllers\MetaTagController;
use App\Frontend\Controllers\StationController;
use App\Frontend\Controllers\TabSearchController;
use App\Frontend\Controllers\TransportController;
use App\Frontend\Controllers\CityController;
use App\Frontend\Controllers\PagePostController;
use App\Frontend\Controllers\PostController;
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
    Route::delete('/logout', [LoginController::class, 'logout']);

    // WishList
    Route::post('/wishlist', [WishListController::class, 'upsertWishList']);
    Route::post('/wishlist/list', [WishListController::class, 'getWishLists']);

    // Customer
    Route::post('/customer', [CustomerController::class, 'getCustomer']);
    Route::put('/customer', [CustomerController::class, 'update']);
    Route::put('/customer/announcement-condition', [CustomerController::class, 'updateAnnouncementCondition']);

    // Confirm password
    Route::put('/confirm-password', [ConfirmPasswordController::class, 'updatePassword']);

    // Estate
    Route::post('/estate/estate-3d', [EstateController::class, 'updateEstateId3D']);

    // Annoucement
    Route::put('/announcement', [AnnouncementController::class, 'markRead']);
    Route::delete('/announcement', [AnnouncementController::class, 'delete']);
    Route::post('/announcement/list', [AnnouncementController::class, 'listAnnouncement']);

});

// auth
Route::post('/verify', [VerificationController::class, 'verifyEmail']);
Route::post('/register', [RegisterController::class, 'registerCustomer']);
Route::post('/reconfirmation-email', [RegisterController::class, 'reconfirmEmail']);
Route::post('/login', [LoginController::class, 'login'])->name('login.check');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'resetPassword']);
Route::post('/fast-register', [RegisterController::class, 'fastRegisterCustomer']);


// register social network
Route::post('/google-login', [LoginController::class, 'socialLogin']);
Route::post('/facebook-login', [LoginController::class, 'socialLogin']);
Route::get('/get-meta-tags', [MetaTagController::class, 'getMetaTags']);

// station
Route::post('/stations/list', [StationController::class, 'getAll']);
Route::post('/stations/hardcode-search', [StationController::class, 'listHardCodeSearch']);

// transport
Route::post('/transports/list', [TransportController::class, 'list']);


// district
Route::post('/district/list', [DistrictController::class, 'list']);
Route::post('/district/customer/list', [DistrictController::class, 'customerList']);
Route::post('/district/hardcode-search', [DistrictController::class, 'listHardCodeSearch']);

// city
Route::post('/city/list', [CityController::class, 'list']);

// tab Search
Route::post('tab-search/list', [TabSearchController::class, 'list']);

//estate
Route::group(['prefix' => 'list'], function () {
    Route::post('/', [EstateController::class, 'search']);
});

Route::group(['prefix' => 'detail'], function () {
    Route::post('/', [EstateController::class, 'detail']);
});

Route::post('/estate/near', [EstateController::class, 'getEstateNear']);

Route::post('/estate/recommend', [EstateController::class, 'getEstatesRecomment']);

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

// page post
Route::put('/manage-page-post/page-post', [PagePostController::class, 'updatePagePost']);
Route::post('/post/list', [PostController::class, 'getPosts']);

Route::get('/test', [AnnouncementController::class, 'testSendNotice'])->name('admin.announcement.store');
Route::get('/test-sendnotice', [AnnouncementController::class, 'testSendEmail'])->name('admin.announcement.send.email');
