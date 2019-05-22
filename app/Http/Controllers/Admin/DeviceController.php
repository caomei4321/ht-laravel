<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DeviceRequest;
use App\Models\Company;
use App\Models\Device;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index(Device $device)
    {
        if (Auth::user()->hasRole('administrator')) {
            $devices = $device->all();
        } else {
            $devices = $device->where('company_id', Auth::user()->company_id)->get();
        }

        return view('admin.device.index', [
            'devices' => $devices
        ]);
    }

    public function create(Company $company, Device $device)
    {
        return view('admin.device.create_and_edit', [
            'companies' => $company->all(),
            'device' => $device
        ]);
    }


    public function store(DeviceRequest $request, Device $device)
    {
        if ($request->user()->hasRole('administrator')) {
            $device->create($request->only([
                'device_no',
                'remark',
                'company_id'
            ]));
        } else {
            $device->create([
                'device_no' => $request->device_no,
                'remark' => $request->remark,
                'company_id' => $request->user()->company_id
            ]);
        }

        return redirect()->route('device.index');
    }

    /* public function show(Request $request, Device $device)
     {
         $htDatas = $device->htData;
         $htDates = [];  //温湿度
         $i = 0;
         foreach ($htDatas as $htData) {
             $htDates[$i][0] = $htData['temperature'];  //温度
             $htDates[$i][1] = $htData['humidity'];  //湿度
             $htDates[$i][2] = $htData['created_at']->format('Y-m-d H:i:s');
             $i++;
         }
         //dd($htDates);
         return view('admin/ht/show', [
             'htDates' => $htDates     //温湿度
         ]);
     }*/

    public function edit(Device $device, Company $company)
    {
        $this->authorize('own', $device);

        return view('admin.device.create_and_edit', [
            'device' => $device,
            'companies' => $company->all()
        ]);
    }

    public function update(DeviceRequest $request, Device $device)
    {
        $this->authorize('own', $device);

        $device->update($request->only([
            'device_no',
            'remark',
            'company_id'
        ]));
        return redirect()->route('device.index');
    }

    public function destroy(Device $device)
    {
        $this->authorize('own', $device);
        $device->delete();

        return response()->json([
            'status' => 1,
            'msg' => '删除成功'
        ]);
    }

    /**
     * 调用百度地图显示设备位置
     *
     * @param  \App\Models\Device $device
     * @return \Illuminate\Http\Response
     */
    public function map(Device $device)
    {
        $devices = $device->all();
        $address = [];
        $i = 0;
        foreach ($devices as $k) {
            $location = $this->getLocation($k->address);
            $address[$i]['id'] = $k->id;
            $address[$i]['lng'] = $location->result->location->lng;
            $address[$i]['lat'] = $location->result->location->lat;
            $i++;
        }
        return view('admin/ht/map', [
            'address' => $address
        ]);
    }

    /**
     * 调用百度地图获得设备经纬度
     *
     * @param  $address
     * @return 位置信息的对象 $location
     */
    protected function getLocation($address)
    {
        $url = 'http://api.map.baidu.com/geocoder/v2/?address=' . $address . '&output=json&ak=F6subxg8j4A1f28mhgryfUs0dxO8PQ8o';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $location = curl_exec($ch);
        return json_decode($location);
    }
}
