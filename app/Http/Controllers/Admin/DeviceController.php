<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Device $device)
    {

        return view('admin/ht/index', [
            'devices' => $device->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/ht/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DeviceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceRequest $request, Device $device)
    {
        $device->create($request->only([
            'name',
            'device_no',
            'address',
            'remark',
        ]));
        return redirect()->route('device.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device $device
     * @param  \App\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Device $device)
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('admin/ht/edit', [
            'device' => $device
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Device $device
     * @return \Illuminate\Http\Response
     */
    public function update(DeviceRequest $request, Device $device)
    {
        $device->update($request->only([
            'name',
            'device_no',
            'address',
            'remark',
        ]));
        return redirect()->route('device.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return [];
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
