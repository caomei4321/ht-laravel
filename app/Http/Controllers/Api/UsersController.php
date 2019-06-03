<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Device;
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

    public function thisUser()
    {
        $user = $this->user();
        $user->roles = $user->getRoleNames();
        return $user;
    }

    //打卡机器公司员工接口
    public function companyUsers(Request $request)
    {
        if (!$request->license) {
            return [];
        }
        $license = $request->license;
        $company = Device::where('device_no',$license)->first()->company()->first();//->users()->get();
        if (!$company) {
            return [];
        }
        $users = $company->users()->get();
        return $this->response->array([
            'data'      => $users,
            'success'   => 1
        ]);

    }

    //小程序公司员工接口
    public function allPerson()
    {
        $companyId = $this->user()->company_id;
        $company = Company::find($companyId);
        $users = $company->users()->get();
        return $this->response()->array([
            'data'      => $users,
            'success'   => 1
        ]);

    }

    //打卡接口
    public function userRecord(Request $request)
    {
        $device = Device::where('device_no', $request->license)->first();
        if ($device) {
            $companyId = $device->company_id;
        } else {
            return $this->response->errorBadRequest('请求错误');
        }
        $user = User::where([
            ['job_number', $request->job_number],
            ['company_id', $companyId]
            ])->first();
        if ($user) {
            $userId = $user->id;
        } else {
            return $this->response->errorBadRequest('请求错误');
        }
        $data['user_id'] = $userId;
        $data['job_number'] = $request->job_number;
        $data['license'] = $request->license;
        UserRecord::create($data);
        return $this->response()->array([
            'status' => 1,
            'message' => '打卡成功'
        ]);
    }

    //员工录入接口
    public function userEntry(Request $request, User $user)
    {
        //$data = $request->only(['name','job_number','department_id','license']);
        //return $data;
        $data = $request->all();
        $imgdata = $request->img;
        $base64_str = substr($imgdata, strpos($imgdata, ",") + 1);
        $image = base64_decode($base64_str);
        //$imgname=rand(1000,10000).time().'.jpg';
        $imgname = $request->name.$request->job_number. '.jpg';
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

    //人员详情
    public function personDetail(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        return $this->response()->array($user);
    }
}
