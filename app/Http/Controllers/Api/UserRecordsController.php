<?php

namespace App\Http\Controllers\Api;

use App\Models\UserRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserRecordsController extends Controller
{
    public function records(User $user)
    {
        $users = $user->find($this->user());
        return $users->user_records();
    }

    /*
     * 打卡记录
     * */
    public function attendance(Request $request)
    {
        $startTime = date('Y-m-01', strtotime(date("Y-m-d")));  //本月第一天
        $endTime = date("Y-m-d");       //当天
        $days = $this->getDays($startTime, $endTime);  //本月除去周末的天数

        if ($request->type == 'company_manage') {
            $companyId = $this->user()->company_id;

            if (!$companyId) {
                return $this->response->noContent();
            }

            return User::where('company_id', $companyId)
                ->get()
                ->map(function (User $user) use ($startTime, $endTime, $days) {
                    $data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => $user->image
                    ];

                    $workingAt = $user->department()->first()->working_at;

                    $on_time = $user->user_records()
                        ->whereDate('created_at', '>=', $startTime)
                        ->whereDate('created_at', '<', $endTime)
                        ->whereTime('created_at', '<', $workingAt)
                        ->selectRaw('DATE(created_at) as date')
                        ->groupBy('date')
                        ->get();
                    $data['on_time_count'] = count($on_time);
                    $data['late_count'] = $days - $data['on_time_count'];

                    return $data;
                });

        } else {
            $user = User::find($this->user()->id);
            $workingAt = $user->department()->first()->working_at;
            $on_time = $user->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->whereDate('created_at', '<', $endTime)
                ->whereTime('created_at', '<', $workingAt)
                ->selectRaw('DATE(created_at) as date')
                ->groupBy('date')
                ->get();

            $user->on_time_count = count($on_time);

            // 缺勤次数 == 总天数-准时出勤次数-周六周日天数
            $late_count = $days - $user->on_time_count;  //缺勤次数

            $user->late_count = $late_count;

            $user->records =  $user->user_records()
                            ->whereDate('created_at', '>=', $startTime)
                            ->get(['id', 'time']);
            return $user;
        }
    }


    /*
     * 小程序搜索接口
     * */
    public function search(Request $request)
    {
        $companyId = $this->user()->company_id;
        if (!$companyId) {
            return $this->response->noContent();
        }
        if (isset($request->startdate) && isset($request->enddate)) {

            $startTime = $request->startdate;
            $endTime = $request->enddate;

            $days = $this->getDays($startTime, $endTime);  //除去周末的天数

            $userData['data'] = User::where('company_id', $companyId)
                ->get()
                ->map(function (User $user) use ($startTime, $endTime, $days) {
                    $data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => $user->image
                    ];

                    $workingAt = $user->department()->first()->working_at;

                    $on_time = $user->user_records()
                        ->whereDate('created_at', '>=', $startTime)
                        ->whereDate('created_at', '<', $endTime)
                        ->whereTime('created_at', '<', $workingAt)
                        ->selectRaw('DATE(created_at) as date')
                        ->groupBy('date')
                        ->get();
                    $data['on_time_count'] = count($on_time);
                    $data['late_count'] = $days - $data['on_time_count'];

                    return $data;
                });
            $userData['search_date']['start_date'] = $startTime;
            $userData['search_date']['end_date'] = $endTime;
            return $userData;
        }

        if (isset($request->startdate) || isset($request->enddate)) {

            $date = $request->startdate ? $request->startdate : $request->enddate;

            $userData['data'] = User::where('company_id', $companyId)
                ->get()
                ->map(function (User $user) use ($date) {
                    $data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => $user->image,
                    ];

                    $workingAt = $user->department()->first()->working_at;

                    $on_time = $user->user_records()
                        ->whereDate('created_at', '=', $date)
                        ->whereTime('created_at', '<', $workingAt)
                        ->selectRaw('DATE(created_at) as date')
                        ->groupBy('date')
                        ->get();
                    $data['on_time_count'] = count($on_time);

                    //$date['late_count'] = '1';
                    if ($data['on_time_count'] == 0) {
                        $data['late_count'] = 1;
                    } else {
                        $date['late_count'] = 0;
                    }
                    return $data;
                });
            $userData['search_date'] = $date;

            return $userData;
        }
    }

    /*
     * 统计
     * */
    public function count()
    {
        $companyId = $this->user()->company_id;

        $year = date("Y");

        //return $this->monthCount(2019,6,1);
        $data['year']  = $year;

        for ($i = 1; $i <= 12; $i++) {
            if (($i) > date('m')) {   //当 i 大于当前月份时
                $data['on_time_count'][$i-1] = 0;
                $data['late_count'][$i-1] = 0;

                continue;
            }

            $monthCount = $this->monthCount($year, $i, $companyId);

            $data['on_time_count'][$i-1] = $monthCount['on_time_count'];
            $data['late_count'][$i-1] = $monthCount['late_count'];
        }

        return $this->response->array($data);
    }

    protected function monthCount($year, $month, $companyId)
    {
        $firstDay = date("Y-$month-01");

        if ($month < 10) {
            $month = "0".$month;
        }

        if (date('Y-m') == date("Y-$month") ) {
            $lastDay = date('Y-m-d');
        } else {
            $lastDay = date('Y-m-d', strtotime("$firstDay +1 month"));
        }

        $days = $this->getDays($firstDay,$lastDay);

        //查询月的公司所有用户的缺勤和准时记录
        $records = User::where('company_id', $companyId)
                    ->get()
                    ->map(function (User $user) use ($year, $month, $days) {
                        $workingAt = $user->department()->first()->working_at;

                        $onTime = $user->user_records()
                                     ->whereYear('created_at', $year)
                                     ->whereMonth('created_at', $month)
                                     ->whereTime('created_at', '<', $workingAt)
                                     ->selectRaw('DATE(created_at) as date')
                                     ->groupBy('date')
                                     ->get();

                        $data['on_time_count'] = count($onTime);
                        $data['late_count'] = $days - $data['on_time_count'];

                        return $data;
                    });

        $data['on_time_count'] = 0;
        $data['late_count'] = 0;

        foreach ($records as $record) {
            $data['on_time_count'] = $data['on_time_count'] + $record['on_time_count'];
            $data['late_count'] = $data['late_count'] + $record['late_count'];
        }
        return $data;
    }

    /*
     * 计算两个日期之间除周末外的天数
     * */
    protected function getDays($date1, $date2, $strto = true)
    {

        if ($strto) {
            $date1 = strtotime($date1);
            $date2 = strtotime($date2);
        }
        $delta = ($date2 - $date1) / (60 * 60 * 24);

        $weekEnds = 0;

        for ($i = 0; $i < $delta; $i++) {
            if (date('w', $date1) == 0 || date('w', $date1) == 6) $weekEnds++;
            $date1 += 60 * 60 * 24;
        }
        return $delta - $weekEnds;
    }
}
