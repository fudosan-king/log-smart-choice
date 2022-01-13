<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\GroupEstateController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\ImportManagementSystemController;


Route::group(['/'], function () {
    Voyager::routes();

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/{id}/estate/', [GroupEstateController::class, 'view'])->name('admin.groups.estate');
        Route::post('/{id}/estate/', [GroupEstateController::class, 'save'])->name('admin.groups.save');
    });

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('admin.about.index');
        Route::post('/', [AboutController::class, 'save'])->name('admin.about.save');
    });

    Route::group(['prefix' => 'estates'], function () {
        Route::get('/', [EstateController::class, 'index'])->name('voyager.estates.index');
        Route::put('/{id}/update', [EstateController::class, 'update'])->name('voyager.estates.update');
        Route::get('/{id}/edit', [EstateController::class, 'edit'])->name('voyager.estates.edit');
    });

    Route::get('/{pageId}/tags', [TagsController::class, 'indexTags'])->name('admin.page.tags.index');
    Route::get('/import', [ImportManagementSystemController::class, 'index'])->name('admin.station.index');
    Route::post('/station/import', [ImportManagementSystemController::class, 'importStation'])->name('admin.station.import');
    Route::post('/customer/import', [ImportManagementSystemController::class, 'importCustomer'])->name('admin.customer.import');

    // Route::group(['prefix' => 'estates'], function () {
    //     Route::get('/', [EstateController::class, 'index'])->name('voyager.estates.index');
    // });
});