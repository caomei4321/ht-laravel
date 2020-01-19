<?php

namespace App\Http\Controllers\Api;

use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $request = $request->all();
        $tetsTxt = '2020119.txt';
        $filePath = storage_path('app/test');

        if (!is_dir(public_path() . '/test')) {
            mkdir(public_path() . '/test', 0777, true);
        }

        $fp = fopen(public_path() . '/test/test.txt',"ab");

        //$size = strlen(json_encode($request));

        fwrite($fp,json_encode($request));
        fclose($fp);

        return 1111;



    }
}
