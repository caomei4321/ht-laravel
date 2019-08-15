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
    Route::post('fileUpload','Admin\FileUploadController@save')->name('admin.fileUpload.save');

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
        // 车牌管理
        Route::any('license', 'Admin\LicenseController@index')->name('license.index');
        Route::any('license/create', 'Admin\LicenseController@create')->name('license.create');
        Route::post('license/store', 'Admin\LicenseController@store')->name('license.store');
        Route::get('license/edit', 'Admin\LicenseController@edit')->name('license.edit');
        Route::post('license/update', 'Admin\LicenseController@update')->name('license.update');
        Route::delete('license/{license}', 'Admin\LicenseController@delete')->name('license.delete');

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
            //Route::get('version', 'Admin\VersionController@index')->name('version.index');
            Route::resource('version', 'Admin\VersionController')->names([
                'index' => 'admin.version.index',
                'store' => 'admin.version.store',
                'create' => 'admin.version.create',
                'destroy' => 'admin.version.destroy',
                'update' => 'admin.version.update',
                'show' => 'admin.version.show',
                'edit' => 'admin.version.edit',
            ]);

            Route::get('alarm','Admin\AlarmController@index')->name('admin.alarm.index');   //警报列表（唐）
            Route::delete('alarm/{alarm}','Admin\AlarmController@destroy')->name('admin.alarm.delete');   //删除警报信息（唐）
            Route::get('helmetAlarm','Admin\HelmetAlarmController@index')->name('admin.helmetAlarm.index');   //警报列表（邵）
            Route::delete('helmetAlarm/{helmetAlarm}','Admin\HelmetAlarmController@destroy')->name('admin.alarm.delete');   //删除警报信息（唐）
        });
    });
});
