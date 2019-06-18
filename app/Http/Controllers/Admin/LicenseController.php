<?php

namespace App\Http\Controllers\Admin;

use App\Models\License;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LicenseController extends Controller
{
    public function index(License $license)
    {
        $license = $license::all();
        return view('admin.license.license', compact('license'));
    }

    public function create()
    {
        return view('admin.license.create_license');
    }

    public function store(License $license, Request $request)
    {
        $license->fill($request->all());
        $license->save();
        return redirect()->route('license.index');
    }

    public function edit(License $license, Request $request)
    {
        $license = $license::find($request['id']);
        return view('admin.license.edit_license', compact('license'));
    }

    public function update(License $license, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['updated_at'] = date('Y-m-d H:i:s', time());
        $license::where('id', $data['id'])->update($data);
        return redirect()->route('license.index');
    }

    public function delete(License $license, Request $request)
    {
        if($license->delete()) {
            return [
                'status' => 1,
                'msg'    => '删除成功'
            ];
        } else
            return [
                'status' => 0,
                'msg'    => '删除失败'
            ];
    }
}