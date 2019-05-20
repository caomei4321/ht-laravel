<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserRecord;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        //$user = Auth::guard('admin')->user();
        return view('admin.index');
    }

    public function set()
    {
        return view('admin.administrator.setting',[
            'administrator' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:2',
            'email'=> 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return redirect()->route('index.set')
                    ->withErrors($validator)
                    ->withInput();
        }
        $data = $request->all();
        if (strlen($data['password'])<57) {
            $data['password'] = bcrypt( $data['password']);
        }
        $request->user()->update($data);
        return redirect()->route('index.set');
    }

    public function common(User $user,UserRecord $userRecord)
    {
        //公司员工数量
        $user_count = $user->all()->count();
        //dd(Carbon::now()->startOfMonth());
        //本月新增员工
        $new_user_count = $user->whereDate('created_at','>=',Carbon::now()->startOfMonth())->count();
        //本月迟到次数
        $late_user_count = $userRecord->whereDate('created_at','>=',Carbon::now()->startOfMonth())
                                        ->whereTime('created_at','>',Auth::user()->working_at)
                                        ->whereTime('created_at','<','12:00:00')
                                        ->count();

        //当天打上班卡人数
        $today_start_record = $userRecord->select(DB::raw('count(*) as user_count, user_id'))
                                         ->whereDate('created_at',Carbon::today())
                                         ->whereTime('created_at','<','12:00:00')
                                         ->groupBy('user_id')
                                         ->get()->count();
        //下班卡人数
        $today_end_record = $userRecord->select(DB::raw('count(*) as user_count, user_id'))
                                        ->whereDate('created_at',Carbon::today())
                                        ->whereTime('created_at','>','12:00:00')
                                        ->groupBy('user_id')
                                        ->get()->count();

        //当天迟到人数
        $today_late_user = $userRecord->select(DB::raw('count(*) as user_count, user_id'))
                                        ->whereDate('created_at',Carbon::today())
                                        ->whereTime('created_at','>',Auth::user()->woking_at)
                                        ->whereTime('created_at','<','12:00:00')
                                        ->groupBy('user_id')
                                        ->get()->count();
        //本月出勤
        /*$aa = DB::table('user_records')->whereDate('created_at','>=',Carbon::now()->startOfMonth())
                                        ->groupBy('date')
                                        ->get([DB::raw('DATE(created_at) as date'),DB::raw('COUNT(*) as value')])
                                        ->toArray();*/

        return view('admin.common',[
            'count' => [
                'user_count' => $user_count,
                'new_user_count' => $new_user_count,
                'late_user_count' => $late_user_count
            ],
            'record' => [
                'start_record' => $today_start_record,
                'end_record' => $today_end_record,
                'late_user' => $today_late_user
            ]
        ]);
    }
}
