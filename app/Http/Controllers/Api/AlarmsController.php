<?php

namespace App\Http\Controllers\Api;

use App\Models\Alarm;
use App\Models\Helmet;
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

    public function helmetAlarm(Request $request, HelmetAlarm $helmetAlarm, Helmet $helmet)
    {
        //return $request->all();

        $data = [
            'device_id'     => $request->deviceId,
            'alarm_time'    => $request->alarmTime,
            'alarm_pic_url' => $request->url,
            'sum'           => $request->sum
        ];
        $helmetAlarm->fill($data);
        $helmetAlarm->save();

        $helmetData = $request->data;

        foreach ($helmetData as $value) {

            $helmetAlarm->helmet()->save($helmet->fill($value));
        }

        //$helmetAlarm->helmet()->

        return response()->json([
            'msg'    => '上传成功',
            'status' => 1
        ]);
    }
}
