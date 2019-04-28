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

Route::get('/', function () {
    return view('welcome');
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
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm');
    Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::get('/device/map', 'Admin\DeviceController@map')->name('device.map');
        Route::resource('device', 'Admin\DeviceController');
        Route::resource('user','Admin\UsersController');
        Route::resource('userRecord','Admin\UserRecordsController');
        Route::post('userRecord/search','Admin\UserRecordsController@getSearch')->name('userRecord.search');
        Route::resource('department','Admin\DepartmentsController');
        Route::get('administrator/set','Admin\IndexController@set')->name('index.set');
        Route::put('administrator/update/{administrator}','Admin\IndexController@update')->name('index.update');
        Route::get('common','Admin\IndexController@common')->name('index.common');
    });
});
