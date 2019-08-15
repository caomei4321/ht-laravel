<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alarm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlarmController extends Controller
{
    public function index(Alarm $alarm)
    {
        $alarms = $alarm->paginate(15);
        return view('admin.alarm.index',compact('alarms'));
    }

    public function destroy(Alarm $alarm)
    {
        $alarm->delete();

        return response()->json(['status' => 1, 'msg' => '删除成功']);
    }
}
