<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelmetAlarm extends Model
{
    protected $fillable = [
        'device_id', 'alarm_time', 'alarm_pic_url', 'color_type', 'helmet_type'
    ];
}
