<?php

namespace App\Http\Controllers\Api;

use App\Models\Alarm;
use App\Models\Helmet;
use Illuminate\Http\Request;
use App\Models\HelmetAlarm;
use Illuminate\Support\Facades\Storage;

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
        $imgdata = $request->url;
        //$base64_str = substr($imgdata, strpos($imgdata, ",") + 1);
        $image = base64_decode($imgdata);

        $imgname = $request->deviceId.time($request->alarmTime). '.jpg';

        Storage::disk('public')->put('helmet/'.$imgname,$image);

        $url = env('APP_URL') . '/uploads/images/users/' . 'helmet/'.$imgname;

        /*Storage::disk('public')->put($imgname, $image);
        $data['image'] = env('APP_URL') . '/uploads/images/hel/' . $imgname;*/

        $data = [
            'device_id'     => $request->deviceId,
            'alarm_time'    => $request->alarmTime,
            'alarm_pic_url' => $url,
            'sum'           => $request->sum
        ];
        $helmetAlarm->fill($data);
        $helmetAlarm->save();

        $helmetData = $request->data;

        foreach ($helmetData as $value) {
            $data = new Helmet($value);
            $helmetAlarm->helmets()->save($data);
        }

        return response()->json([
            'msg'    => '上传成功',
            'status' => 1
        ]);
    }
}
