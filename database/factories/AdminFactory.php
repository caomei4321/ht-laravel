<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018-12-13
 * Time: 14:12
 */

use Faker\Generator as Faker;

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    static $password;

    return [
        'name' => 'admin',
        'email' => '888888@qq.com',
        'password' => $password,
        'remember_token' => str_random(10),
    ];
});