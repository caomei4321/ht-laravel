<?php

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

Route::get('', function () {
    return redirect()->route('admin.index');
});

/*Route::namespace('Admin')->group(function () {
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::group(['middleware' => ['auth.admin']], function () {
            Route::get('/', 'IndexController@index')->name('index');
        });
    });
});*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.index');
    Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::get('/device/map', 'Admin\DeviceController@map')->name('device.map');
        Route::resource('device', 'Admin\DeviceController');
        Route::resource('user','Admin\UsersController');
        Route::get('userRecord','Admin\UserRecordsController@index')->name('userRecord.search');
        Route::delete('userRecord/{userRecord}','Admin\UserRecordsController@destroy');
        Route::resource('department','Admin\DepartmentsController');
        Route::get('administrator/set','Admin\IndexController@set')->name('index.set');
        Route::put('administrator/update/{administrator}','Admin\IndexController@update')->name('index.update');
        Route::get('common','Admin\IndexController@common')->name('index.common');

        Route::get('recordReport','Admin\RecordReportController@recordReport')->name('report.recordReport');
        Route::get('recordReport/download/','Admin\RecordReportController@recordReportDownload')->name('report.download');
        Route::get('detailReport','Admin\RecordReportController@detailReport')->name('report.detailReport');
        Route::get('detailReport/download/','Admin\RecordReportController@detailReportDownload')->name('report.detailReportDownload');
    });
});
