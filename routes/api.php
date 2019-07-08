<?php

use Illuminate\Http\Request;

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
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function ($api) {
    $api->get('version', function () {
        return response('this is version v1');
    });
    $api->get('htData', 'HtDataController@store');
    $api->get('users', 'UsersController@users');

    $api->get('companyUsers', 'UsersController@companyUsers');  //公司员工信息接口
    $api->post('userRecord', 'UsersController@userRecord');  //打卡接口

    $api->post('test', 'UsersController@test');
    // 登录
    $api->post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');
    //小程序登录
    $api->post('weappAuthorizations', 'AuthorizationsController@weappStore');
    //刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    $api->delete('authorizations/destroy', 'AuthorizationsController@delete')
        ->name('api.authorizations.delete');

    $api->post('wuthorizations', 'AuthorizationsController@weappStore');
    $api->get('userRecords','UserRecordsController@records');

    $api->post('breakpointRecord', 'UsersController@breakpointRecord');

    $api->group(['middleware' => 'auth:api,apiAdmin'],function ($api) {

        $api->post('resetPassword', 'AuthorizationsController@resetPassword'); //修改密码

        $api->get('thisUser', 'UsersController@thisUser');   //当前用户信息

        $api->get('devices','DevicesController@deviceList');  //返回设备列表

        $api->get('departments','DepartmentsController@departmentList');  //返回设备列表

        $api->post('userEntry', 'UsersController@userEntry');  //录信息接口

        $api->get('personDetail', 'UsersController@personDetail');  //人员详情

        $api->get('allPerson', 'UsersController@allPerson');  //人员详情

        $api->get('attendance', 'UserRecordsController@attendance');  //人员详情

        $api->post('search', 'UserRecordsController@search');  //查询接口

        $api->get('count', 'UserRecordsController@count');  //统计
    });

    $api->any('car/get', 'CarNumberController@getTest');

    $api->any('car/serial', 'CarNumberController@serial');

    $api->any('car/receive', 'CarNumberController@receive');

    $api->get('carRecord', 'CarsController@carRecord');  // 车辆统计

    $api->post('fileUpload','FileUploadController@save')->name('api.fileUpload.save');

    $api->get('version','VersionsController@version');
});
