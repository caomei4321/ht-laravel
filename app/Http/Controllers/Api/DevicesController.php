<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function deviceList()
    {
        $companyId = $this->user()->company_id;

        $devices = Device::where('company_id',$companyId)->get(['id','device_no','remark']);

        return $devices;
    }

}
