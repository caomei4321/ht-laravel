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

        if ($request->user()->hasRole('administrator')) {
            $userRecords = $user->all();
        } else {
            $userRecords = $user->where('company_id', $request->user()->company_id)->get();
        }

        foreach ($userRecords as $userRecord) {
            $department = $userRecord->department()->first();

            $workingAt = $department['working_at'];  //用户所在部门的上班时间
            $endAt = $department['end_at'];  //用户所在部门的下班时间

            $over = date('H:i:s', strtotime("+1 hours", strtotime($endAt)));  //开始算加班时间（下班时间一小时以后开始算加班）

            //迟到次数
            $userRecord->lateCount = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '<', '12:00:00')
                ->whereTime('created_at', '>', $workingAt)
                ->selectRaw('DATE(created_at) as date,COUNT(*) as value')
                ->groupBy('date')
                ->get();
            $userRecord->lateCount = count($userRecord->lateCount); //迟到次数

            //加班次数
            $overtimeCounts = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '>=', $over)
                ->selectRaw('DATE(created_at) as date,COUNT(*) as value')
                ->groupBy('date')->get();

            //$userRecord->overtimeCount = count($userRecord->overtimeCount);
            $overTimes = 0; //加班时长
            /*$userOvertimes = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '>', $over)->get();*/
            foreach ($overtimeCounts as $overtimeCount) {

                $userOvertime = $userRecord->user_records()
                                            ->whereDate('created_at',$overtimeCount['date'])
                                            ->orderBy('created_at','desc')
                                            ->first();
                $min = (strtotime(date('H:i:00', strtotime($userOvertime->created_at))) - strtotime($endAt)) / 60;
                $overTimes = $overTimes + $min;
            }
            //加班时长
            $userRecord->overTime = $overTimes;
            //加班次数
            $userRecord->overtimeCount = count($overtimeCounts);
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

        if (!$request->user()->hasRole('administrator')) {
            $companyId = $request->user()->company_id;
        } else {
            $companyId = null;
        }

        return $excel->download(new UserRecordsExport($startTime, $endTime, $companyId), '考勤报表.xlsx');
    }

    //每日报表
    public function detailReport(User $user, Request $request)
    {
        $searchDate = $request->search_date ? $request->search_date : date('Y-m-d', time());

        if ($request->user()->hasRole('administrator')) {
            $userRecords = $user->all();
        } else {
            $userRecords = $user->where('company_id', $request->user()->company_id)->get();
        }

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
                ->orderBy('created_at', 'desc')
                ->first();
            if (isset($endwork_at)) {
                $userRecord->endwork_at = $endwork_at->created_at; //下班打卡时间

                $department = $userRecord->department()->first();

                //计算加班时长
                $endAt = $department['end_at'];  //用户所在部门的下班时间
                $min = (strtotime(date('H:i:00', strtotime($endwork_at->created_at))) - strtotime($endAt)) / 60;

                $userRecord->overTime = $min > 0 ? $min : 0; //加班时长
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
    public function detailReportDownload(Excel $excel, Request $request)
    {
        $searchDate = $request->search_date ? $request->search_date : date('Y-m-d', time());
        if (!$request->user()->hasRole('administrator')) {
            $companyId = $request->user()->company_id;
        } else {
            $companyId = null;
        }

        return $excel->download(new DetailRecordExport($searchDate, $companyId), '详情报表.xlsx');
    }
}
