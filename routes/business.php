<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\BidController;
use App\Http\Controllers\Business\BidProfileController;
use App\Http\Controllers\Business\ProjectController;
use App\Http\Controllers\Business\StatusReportController;
use App\Http\Controllers\Business\TargetAchievedController;
use App\Http\Controllers\Business\SettingsController;
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
 Route::group(['prefix' => 'business','middleware' => ['auth','CheckMaintenanceStatus'] ], function() {
    Route::resource('business', BusinessController::class);
    Route::resource('bids', BidController::class);
    Route::resource('targets', TargetAchievedController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('bidprofile', BidProfileController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('statusreport', StatusReportController::class);
    Route::post('/bid/status','App\Http\Controllers\Business\BidController@bidStatus');
    Route::post('/validateBidUrl', 'App\Http\Controllers\Business\BidController@CheckBidUrl')->name('validateBidUrl');  
    Route::get('/delete/{id}', 'App\Http\Controllers\Business\ProjectController@delete')->name('projects.delete');
            

});
