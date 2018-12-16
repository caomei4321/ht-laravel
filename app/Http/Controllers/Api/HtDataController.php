<?php

namespace App\Http\Controllers\Api;

use App\Models\HtData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HtDataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, HtData $htData)
    {
        //dd($request->H);
        $htData->create([
            'device_id' => $request->id,
            'temperature' => $request->T,
            'humidity' => $request->H
        ]);
        return response('success');
    }
}
