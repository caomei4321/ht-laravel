<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HtData extends Model
{
    protected $fillable = [
        'device_id', 'temperature', 'humidity'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
