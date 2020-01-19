<?php

namespace App\Http\Controllers\Admin;

use App\Models\CarNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarRecordController extends Controller
{

    public function index(CarNumber $carNumber, Request  $request)
    {
        $start_time = $request->start_time ? $request->start_time : date('Y-m-d', time());
        $end_time = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $license = $request->license ? $request->license : '';

        $carNumbers = $carNumber
            ->whereDate('created_at', '>=', $start_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('license', 'like', '%'.$license.'%')
            ->paginate(15);

        return view('admin.carRecord.index', [
            'carNumbers' => $carNumbers,
            'filter'     => [
                'start_time' => $start_time,
                'end_time'   => $end_time,
                'license'    => $license
            ]
        ]);
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {

    }
}
