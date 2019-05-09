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
    public function __construct($startTime,$endTime)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
    public function view(): view
    {
        $startTime = $this->startTime;
        $endTime = $this->endTime;
        //$startTime = $request->start_time ? $request->start_time : date('Y-m-01', strtotime(date("Y-m-d")));
        //$endTime = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $workingAt = Auth::user()->working_at;
        $endAt = Auth::user()->end_at;
        $userRecords = User::all();
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
                ->whereTime('created_at','>','16:30:00')
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
            $userRecord->overTimes = $overTimes;
        }

        return view('admin.recordReport.index', [
            'userRecords' => $userRecords,
        ]);
    }
}
