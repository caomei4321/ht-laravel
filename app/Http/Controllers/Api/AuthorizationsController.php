<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\AuthorizationRequest;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $credentials['phone'] = $request->phone;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->responseWithToken($token);
    }

    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->responseWithToken($token);
    }

    public function delete()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }

    protected function responseWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,   //token值
            'token_type' => 'Bearer',   //token类型
            'expires_in' => Auth::guard('api')->factory()->getTTL()*60   //token过期时间
        ]);
    }
}