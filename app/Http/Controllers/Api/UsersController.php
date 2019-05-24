<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRecord;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    //打卡接口
    public function userRecord(Request $request)
    {
        $user_id = User::where('job_number', $request->job_number)->first()->id;
        $data['user_id'] = $user_id;
        $data['job_number'] = $request->job_number;
        $data['license'] = $request->license;
        UserRecord::create($data);
        return $this->response()->array([
            'status' => 1,
            'message' => '打卡成功'
        ]);
    }

    //员工录入接口
    public function test(Request $request, User $user)
    {
        $data = $request->all();

        $imgdata = $request->img;
        $base64_str = substr($imgdata, strpos($imgdata, ",") + 1);
        $image = base64_decode($base64_str);
        //$imgname=rand(1000,10000).time().'.jpg';
        $imgname = $request->name . '.png';
        Storage::disk('public')->put($imgname, $image);
        $data['image'] = env('APP_URL') . '/uploads/images/users/' . $imgname;

        //$data['job_number'] = $request->img;
        //$data['license'] = $request->license;
        //$data['name'] = $request->name;
        $user->fill([
            'name'          => $data['name'],
            'job_number'    => $data['job_number'],
            'department_id' => $data['department_id'],
            'image_name'    => $imgname,
            'image'         => $data['image'],
            'company_id'    => $this->user()->company_id
        ]);
        $user->save();
        $user->device()->attach($data['license']);
        //UserRecord::create($data);
        return $this->response()->array(['msg' => '保存成功']);
    }
}
