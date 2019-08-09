<?php

namespace App\Http\Controllers\Api;

use App\Models\Alarm;
use Illuminate\Http\Request;
use App\Models\HelmetAlarm;

class AlarmsController extends Controller
{
    public function alarm(Request $request, Alarm $alarm)
    {

        $data = [
            'alarm_id'      => $request->alarmId,
            'channel_name'    => $request->channelName,
            'alarm_type'    => $request->alarmType,
            'alarm_start'   => $request->alarmStart,
            'device_serial' => $request->deviceSerial,
            'alarm_pic_url' => $request->alarmPicUrl
        ];

        $alarm->fill($data);
        $alarm->save();

        return response()->json([
            'msg'    => '上传成功',
            'status' => 1
        ]);
    }

    public function helmetAlarm(Request $request, HelmetAlarm $helmetAlarm)
    {
        $data = [
            'device_id'     => $request->deviceId,
            'alarm_time'    => $request->alarmTime,
            'alarm_pic_url' => $request->url,
            'color_type'    => $request->color_type,
            'helmet_type'   => $request->helmet_type
        ];
        $helmetAlarm->fill($data);
        $helmetAlarm->save();

        return response()->json([
            'msg'    => '上传成功',
            'status' => 1
        ]);
    }
}
