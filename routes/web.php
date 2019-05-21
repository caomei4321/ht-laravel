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
        Route::group(['middleware' => ['role:administrator']], function () {
            Route::resource('/administrators', 'Admin\AdministratorsController')->names([
                'index' => 'admin.administrators.index',
                'store' => 'admin.administrators.store',
                'create' => 'admin.administrators.create',
                'destroy' => 'admin.administrators.destroy',
                'update' => 'admin.administrators.update',
                'show' => 'admin.administrators.show',
                'edit' => 'admin.administrators.edit',
            ]);
            Route::resource('/permissions', 'Admin\PermissionsController')->names([
                'index' => 'admin.permissions.index',
                'store' => 'admin.permissions.store',
                'create' => 'admin.permissions.create',
                'destroy' => 'admin.permissions.destroy',
                'update' => 'admin.permissions.update',
                'show' => 'admin.permissions.show',
                'edit' => 'admin.permissions.edit',
            ]);
            Route::resource('/roles', 'Admin\RolesController')->names([
                'index' => 'admin.roles.index',
                'store' => 'admin.roles.store',
                'create' => 'admin.roles.create',
                'destroy' => 'admin.roles.destroy',
                'update' => 'admin.roles.update',
                'show' => 'admin.roles.show',
                'edit' => 'admin.roles.edit',
            ]);
            Route::resource('company', 'Admin\CompanyController')->names([
                'index' => 'admin.company.index',
                'store' => 'admin.company.store',
                'create' => 'admin.company.create',
                'destroy' => 'admin.company.destroy',
                'update' => 'admin.company.update',
                'show' => 'admin.company.show',
                'edit' => 'admin.company.edit',
            ]);
        });
    });
});
