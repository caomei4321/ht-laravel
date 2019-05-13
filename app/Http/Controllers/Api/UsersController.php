<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRecord;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\Providers\Storage;

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
        $data['license'] = $request->license;
        UserRecord::create($data);
        return $this->response()->array([
            'status' => 1,
            'message' => '打卡成功'
        ]);
    }

    public function test(Request $request)
    {

        $imgdata=$request->img;
        $base64_str = substr($imgdata, strpos($imgdata, ",")+1);
        $image=base64_decode($base64_str);
        $imgname=rand(1000,10000).time().'.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put($imgname,$image);
        $data['job_number'] = env('APP_URL').'/uploads/android/' . $imgname;

        //$data['job_number'] = $request->img;
        $data['license'] = $request->pawd;
        $data['user_id'] = 60;
        UserRecord::create($data);
        return $this->response()->array(['msg' => '保存成功']);
    }
}
