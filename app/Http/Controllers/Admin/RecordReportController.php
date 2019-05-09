<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserRecordsExport;
use App\Exports\DetailRecordExport;
use App\Models\User;
use App\Models\UserRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class RecordReportController extends Controller
{
    //统计报表
    public function recordReport(User $user, Request $request)
    {
        $startTime = $request->start_time ? $request->start_time : date('Y-m-01', strtotime(date("Y-m-d")));
        $endTime = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $workingAt = Auth::user()->working_at;
        $endAt = Auth::user()->end_at;
        $userRecords = $user->all();
        foreach ($userRecords as $userRecord) {
            //迟到次数
            $userRecord->lateCount = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '<', '12:00:00')
                ->whereTime('created_at', '>', $workingAt)
                ->count();
            //加班次数
            $userRecord->overtimeCount = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '>', '16:30:00')
                ->count();
            $overTimes = 0; //加班时长
            $userOvertimes = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '>', '16:30:00')->get();
            foreach ($userOvertimes as $userOvertime) {
                $min = (strtotime(date('H:i:00', strtotime($userOvertime->created_at))) - strtotime($endAt)) / 60;
                $overTimes = $overTimes + $min;
            }
            //加班时长
            $userRecord->overTime = $overTimes;
        }

        return view('admin.recordReport.index', [
            'userRecords' => $userRecords,
            'filter' => [
                'start_time' => $startTime,
                'end_time' => $endTime
            ]
        ]);
    }

    //下载统计报表
    public function recordReportDownload(Excel $excel, Request $request)
    {
        $startTime = $request->start_time ? $request->start_time : date('Y-m-01', strtotime(date("Y-m-d")));
        $endTime = $request->end_time ? $request->end_time : date('Y-m-d', time());

        return $excel->download(new UserRecordsExport($startTime, $endTime), '考勤报表.xlsx');
    }

    //每日报表
    public function detailReport(User $user, Request $request)
    {
        $searchDate = $request->search_date ? $request->search_date : date('Y-m-d',time());

        $userRecords = $user->all();

        foreach ($userRecords as $userRecord) {
            $work_at = $userRecord->user_records()
                                        ->whereDate('created_at', '=', $searchDate)
                                        ->whereTime('created_at', '<', '12:00:00')
                                        ->first();

            if (isset($work_at)) {
                $userRecord->work_at = $work_at->created_at;  //上班打卡时间
            } else {
                $userRecord->work_at = '';
            }

            $endwork_at = $userRecord->user_records()
                                            ->whereDate('created_at', '=', $searchDate)
                                            ->whereTime('created_at', '>', '13:00:00')
                                            ->orderBy('created_at','desc')
                                            ->first();
            if (isset($endwork_at)) {
                $userRecord->endwork_at = $endwork_at->created_at; //下班打卡时间

                //计算加班时长
                $endAt = Auth::user()->end_at;
                $min = (strtotime(date('H:i:00', strtotime($endwork_at->created_at))) - strtotime($endAt)) / 60;

                $userRecord->overTime = $min>0 ? $min : 0; //加班时长
            } else {
                $userRecord->endwork_at = '';
                $userRecord->overTime = 0;
            }
        }

        return view('admin.recordReport.detailRecord', [
            'userRecords' => $userRecords,
            'filter' => $searchDate
        ]);
    }

    //下载每日报表
    public function detailReportDownload(Excel $excel,Request $request)
    {
        $searchDate = $request->search_date ? $request->search_date : date('Y-m-d',time());
        return $excel->download(new DetailRecordExport($searchDate), '详情报表.xlsx');
    }
}
