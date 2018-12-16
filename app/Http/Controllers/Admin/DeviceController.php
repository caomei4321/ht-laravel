<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $htData = $device->htData();
        dd($htData);
        return view('admin/ht/show',[
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
        return view('admin/ht/edit',[
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
        //
    }
}
