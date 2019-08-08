<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    protected $fillable = [
        'alarm_id', 'alarm_name', 'alarm_type', 'alarm_start', 'device_serial', 'alarm_pic_url'
    ];
}
