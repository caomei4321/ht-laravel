<?php

namespace App\Http\Controllers\Api;

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
            return $user->user_records()
                ->whereDate('created_at', '>=', $startTime)
                ->get(['id', 'time']);
        }
    }

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
