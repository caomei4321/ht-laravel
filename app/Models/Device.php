<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name','device_no','address','remark'
    ];

    public function htData()
    {
        return $this->hasMany(HtData::class);
    }
}
