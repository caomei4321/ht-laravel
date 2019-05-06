<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRecordsController extends Controller
{
    public function index(UserRecord $userRecord, Department $department)
    {
        //dd(Carbon::today());
        $userRecords = $userRecord->whereDate('created_at', Carbon::today())->get();
        $departments = $department->all();
        return view('admin.userRecord.index', [
            'userRecords' => $userRecords,
            'departments' => $departments
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(UserRecord $userRecord)
    {
        $userRecord->delete();
        return response()->json([
            'status' => 1,
            'message' => '删除成功'
        ]);
    }

    public function getSearch(Request $request, UserRecord $userRecord, Department $department)
    {
        $start_time = $request->start_time ? $request->start_time : '';
        $end_time = $request->end_time ? $request->end_time : date('Y-m-d', time());
        $job_number = $request->job_number;

        if ($department_id = $request->department_id) {

            $users = Db::table('users')->where('department_id', $request->department_id)->pluck('id');

            $userRecords = $userRecord->whereIn('user_id', $users)
                                        ->whereDate('created_at', '>=', $start_time)
                                        ->whereDate('created_at', '<=', $end_time)
                                        ->where('job_number', 'like', '%' . $job_number . '%')
                                        ->get();
        } else {
            $userRecords = $userRecord->whereDate('created_at', '>=', $start_time)
                                        ->whereDate('created_at', '<=', $end_time)
                                        ->where('job_number', 'like', '%' . $job_number . '%')
                                        ->get();
        }

        return view('admin.userRecord.index', [
            'userRecords' => $userRecords,
            'departments' => $department->all(),
            'filter' => [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'job_number' => $job_number,
                'department_id' => $department_id
            ]
        ]);
    }
}
