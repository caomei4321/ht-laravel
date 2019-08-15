<?php

namespace App\Http\Controllers\Admin;

use App\Models\HelmetAlarm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelmetAlarmController extends Controller
{
    public function index(HelmetAlarm $helmetAlarm)
    {
        $helmetAlarms = $helmetAlarm->paginate(15);

        return view('admin.helmetAlarm.index',compact('helmetAlarms'));
    }

    public function destroy(HelmetAlarm $helmetAlarm)
    {
        $helmetAlarm->delete();

        return response()->json(['status' => 1, 'msg' => '删除成功']);
    }
}
