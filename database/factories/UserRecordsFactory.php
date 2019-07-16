<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019-07-16
 * Time: 14:35
 */
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    $job_number = 'a0002';

    $userRecord = App\Models\UserRecord::where('job_number',$job_number)->orderBy('id','desc')->first();

    $time = date('Y-m-d H:i:s', strtotime($userRecord->time)+24*60*60);

    return [
        'job_number' => $job_number,
        'license' => '71538e5e07d12eba',
        'time' => $time, // secret
    ];
});