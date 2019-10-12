<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;


class recordsExport implements FromCollection
{
    protected $startTime;
    protected $endTime;
    protected $user;

    public function __construct($startTime, $endTime, $user)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->user = $user;
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
    public function collection()
    {
        return new Collection($this->createData());

    }

    public function createData()
    {
        $startTime = $this->startTime;
        $endTime = $this->endTime;
        $user = $this->user;
        //dd($user);

        $user_records = $user->user_records()->whereDate('time', '>=', $startTime)
            ->whereDate('time', '<=', $endTime)
            ->orderBy('id', 'desc')
            ->get(['job_number','time'])->toArray();


        array_unshift($user_records,['工号','打卡时间']);
        //dd($user_records);
        return $user_records;
    }
}
