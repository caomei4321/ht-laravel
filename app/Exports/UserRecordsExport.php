<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class UserRecordsExport implements FromView
{
    protected $startTime;
    protected $endTime;
    protected $companyId;

    public function __construct($startTime, $endTime, $companyId = nul)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->companyId = $companyId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    /*public function collection()
    {
        $userRecords = User::with(['user_records' => function ($query) {
            //$query->count();
            $query->whereTime('created_at','<',Auth::user()->working_at)->count();
        }])->get();
        return $userRecords;
        //$userRecord = $this->record->where()
    }*/
    public
    function view(): view
    {
        $startTime = $this->startTime;
        $endTime = $this->endTime;
        //$startTime = $request->start_time ? $request->start_time : date('Y-m-01', strtotime(date("Y-m-d")));
        //$endTime = $request->end_time ? $request->end_time : date('Y-m-d', time());
        if ($this->companyId) {
            $userRecords = User::where('company_id', $this->companyId)->get();
        } else {
            $userRecords = User::all();
        }
        //$userRecords = User::all();
        foreach ($userRecords as $userRecord) {
            $department = $userRecord->department()->first();

            $workingAt = $department['working_at'];  //用户所在部门的上班时间
            $endAt = $department['end_at'];  //用户所在部门的下班时间

            $over = date('H:i:s', strtotime("+1 hours", strtotime($endAt)));  //开始算加班时间（下班时间一小时以后开始算加班）

            //迟到次数
            $userRecord->lateCount = $userRecord->user_records()
                ->whereDate('time', '>=', $startTime)
                ->whereDate('time', '<=', $endTime)
                ->whereTime('time', '<', '12:00:00')
                ->whereTime('time', '>', $workingAt)
                ->selectRaw('DATE(time) as date,COUNT(*) as value')
                ->groupBy('date')
                ->get();
            $userRecord->lateCount = count($userRecord->lateCount); //迟到次数

            $over = date('H:i:s', strtotime("+1 hours", strtotime($endAt)));  //开始算加班时间（下班时间一小时以后开始算加班）
            //加班次数
            $overtimeCounts = $userRecord->user_records()
                ->whereDate('time', '>=', $startTime)
                ->whereDate('time', '<=', $endTime)
                ->whereTime('time', '>=', $over)
                ->selectRaw('DATE(time) as date,COUNT(*) as value')
                ->groupBy('date')->get();

            $overTimes = 0; //加班时长
            /*$userOvertimes = $userRecord->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<=', $endTime)
                ->whereTime('created_at', '>=', $over)->get();*/
            foreach ($overtimeCounts as $overtimeCount) {
                $userOvertime = $userRecord->user_records()
                    ->whereDate('time', $overtimeCount['date'])
                    ->orderBy('time', 'desc')
                    ->first();

                $min = (strtotime(date('H:i:00', strtotime($userOvertime->time))) - strtotime($endAt)) / 60;
                $overTimes = $overTimes + $min;
            }
            //加班时长
            $userRecord->overTime = $overTimes;
            //加班次数
            $userRecord->overtimeCount = count($overtimeCounts);
        }

        return view('admin.recordReport.index', [
            'userRecords' => $userRecords,
        ]);
    }
}
