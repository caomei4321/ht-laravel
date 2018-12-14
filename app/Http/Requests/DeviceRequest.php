<?php

namespace App\Http\Requests;

class DeviceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'device_no' => 'required',
            'address'   => 'required',
            'remark'    => 'required',
        ];
    }
}
