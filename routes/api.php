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
    $api->post('userRecord', 'UsersController@userRecord');  //打卡接口

    $api->post('test', 'UsersController@test');
    // 登录
    $api->post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');
    //刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    $api->delete('authorizations/destroy', 'AuthorizationsController@delete')
        ->name('api.authorizations.delete');
    $api->group(['middleware' => 'auth:api'],function ($api) {
        $api->get('userRecords','UserRecordsController@records');

        $api->get('devices','DevicesController@deviceList');  //返回设备列表

        $api->post('userEntry', 'UsersController@userEntry');  //录信息接口
    });
});
