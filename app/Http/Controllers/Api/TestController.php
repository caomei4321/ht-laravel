<?php

namespace App\Http\Controllers\Api;

use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(Request $request)
    {
        return $request->all();
    }
}
