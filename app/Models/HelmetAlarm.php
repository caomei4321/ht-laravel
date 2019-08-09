<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelmetAlarm extends Model
{
    protected $fillable = [
        'device_id', 'alarm_time', 'alarm_pic_url', 'sum'
    ];

    public function helmet()
    {
        return $this->hasMany(Helmet::class,'parent_id','id');
    }
}
