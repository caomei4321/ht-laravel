<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\UserRecordsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class UserRecordsController extends Controller
{
    public function index(Request $request, UserRecord $userRecord, Department $department)
    {   //return Excel::download(new UserRecordsExport,'users.xlsx');
        /*$workingAt = Auth::user()->working_at;
        $userRecords = User::with(['user_records' => function ($query) {
            //$query->count();
            $query->whereTime('created_at','<',Auth::user()->working_at)->count();
        }])->get(['name',]);*/

        /*$userRecords = DB::table('users')->select('name')->join('user_records',function ($join) {
            $join->on('users.id', '=', 'user_records.user_id')
                    ->whereTime('user_records.created_at', '<', Auth::user()->working_at)
                    ->count();
        })->get();
        dd($userRecords);*/

        $start_time = $request->start_time ? $request->start_time : date('Y-m-d', time());
        $end_time = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $job_number = $request->job_number ? $request->job_number : '';
        $department_id = $request->department_id ? $request->department_id : '';
        $times = $request->times ? $request->times : '';


        if ($request->user()->hasRole('administrator')) {
            $departments = $department->all();
        } elseif ($request->user()->hasRole('company_manage')) {
            $departments = $department->where('company_id', $request->user()->company_id)->get();
        }

        if ($department_id) {  //提交部门参数时按部门 ID 查询

            $users = Db::table('users')->where('department_id', $department_id)->pluck('id');

        } else {  //查询当前用户公司所有员工记录
            $users = Db::table('users')->where('company_id', $request->user()->company_id)->pluck('id');

        }
        //$userRecords = $userRecord->whereDate('created_at', Carbon::today())->paginate(1);
        if ($times == 1) { //查询上午打卡记录
            $userRecords = $userRecord->whereIn('user_id', $users)
                ->whereDate('created_at', '>=', $start_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('job_number', 'like', '%' . $job_number . '%')
                ->whereTime('created_at', '<=', '12:00:00')
                ->paginate();
        } elseif ($times == 2) {  //查询下午打卡记录
            $userRecords = $userRecord->whereIn('user_id', $users)
                ->whereDate('created_at', '>=', $start_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('job_number', 'like', '%' . $job_number . '%')
                ->whereTime('created_at', '>', '12:00:00')
                ->paginate();
        } else {
            $userRecords = $userRecord->whereIn('user_id', $users)
                ->whereDate('created_at', '>=', $start_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('job_number', 'like', '%' . $job_number . '%')
                ->paginate();
        }

        return view('admin.userRecord.index', [
            'userRecords' => $userRecords,
            'departments' => $departments,
            'filter' => [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'job_number' => $job_number,
                'department_id' => $department_id,
                'times' => $times
            ]
        ]);
    }

    public function destroy(UserRecord $userRecord)
    {
        $userRecord->delete();
        return response()->json([
            'status' => 1,
            'message' => '删除成功'
        ]);
    }

    /*public function getSearch(Request $request, UserRecord $userRecord, Department $department)
    {
        $start_time = $request->start_time ? $request->start_time : '';
        $end_time = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $job_number = $request->job_number ? $request->job_number : '';

        if ($department_id = $request->department_id) {

            $users = Db::table('users')->where('department_id', $request->department_id)->pluck('id');

            $userRecords = $userRecord->whereIn('user_id', $users)
                                        ->whereDate('created_at', '>=', $start_time)
                                        ->whereDate('created_at', '<=', $end_time)
                                        ->where('job_number', 'like', '%' . $job_number . '%')
                                        ->paginate(1);
        } else {
            $userRecords = $userRecord->whereDate('created_at', '>=', $start_time)
                                        ->whereDate('created_at', '<=', $end_time)
                                        ->where('job_number', 'like', '%' . $job_number . '%')
                                        ->paginate(1);
        }

        return view('admin.userRecord.search', [
            'userRecords' => $userRecords,
            'departments' => $department->all(),
            'filter' => [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'job_number' => $job_number,
                'department_id' => $department_id
            ]
        ]);
    }*/

    public function search()
    {

    }
}
