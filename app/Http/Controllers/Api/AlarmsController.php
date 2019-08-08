<?php

namespace App\Http\Controllers\Api;

use App\Models\Alarm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlarmsController extends Controller
{
    public function alarmStore(Request $request, Alarm $alarm)
    {

        $data = [
            'alarm_id'      => $request->alarmId,
            'alarm_name'    => $request->alarmName,
            'alarm_type'    => $request->alarmTypr,
            'alarm_start'   => $request->alarmStart,
            'device_serial' => $request->deviceSerial,
            'alarm_pic_url' => $request->alarmPicUrl
        ];

        $alarm->fill($data);
        $alarm->save();
    }
}
