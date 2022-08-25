<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hardware\HardwareController;
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

 Route::group(['middleware' => ['auth','CheckMaintenanceStatus'] ], function() {
    Route::resource('hardware', HardwareController::class);
    Route::get('hardware/view/{id}', 'App\Http\Controllers\Hardware\HardwareController@view')->name('hardware.view');
   
});
