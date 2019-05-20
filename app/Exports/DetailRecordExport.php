<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DetailRecordExport implements FromView
{
    protected $searchDate;
    protected $companyId;

    public function __construct($searchDate,$companyId = null)
    {
        $this->searchDate = $searchDate;
        $this->companyId = $companyId;

    }

    public function view():view
    {
        $searchDate = $this->searchDate;
        if ($this->companyId) {
            $userRecords = User::where('company_id',$this->companyId)->get();
        } else {
            $userRecords = User::all();
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
                ->orderBy('created_at','desc')
                ->first();
            if (isset($endwork_at)) {
                $userRecord->endwork_at = $endwork_at->created_at; //下班打卡时间

                $department = $userRecord->department()->first();

                //计算加班时长
                $endAt = $department['end_at'];  //用户所在部门的下班时间
                $min = (strtotime(date('H:i:00', strtotime($endwork_at->created_at))) - strtotime($endAt)) / 60;

                $userRecord->overTime = $min>0 ? $min : 0; //加班时长
            } else {
                $userRecord->endwork_at = '';
                $userRecord->overTime = 0;
            }
        }

        return view('admin.recordReport.detailRecord', [
            'userRecords' => $userRecords
        ]);
    }
}
