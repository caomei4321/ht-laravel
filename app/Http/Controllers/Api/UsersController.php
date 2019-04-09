<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRecord;

class UsersController extends Controller
{
    public function users(User $user)
    {
        $users = $user->all();
        return $this->response->array([
            'data' => $users,
            'success' => 1
        ]);
    }

    public function userRecord(Request $request)
    {
        $user_id = User::where('job_number', $request->job_number)->first()->id;
        $data['user_id'] = $user_id;
        $data['job_number'] = $request->job_number;
        UserRecord::create($data);
        return $this->response()->array([
            'status' => 1,
            'message' => '打卡成功'
        ]);
    }
}
