<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helmet extends Model
{
    protected $fillable = [
        'color_type', 'helmet_type', 'parent_id'
    ];

    public function helmetAlarm()
    {
        return $this->belongsTo(Helmet::class,'parent_id','id');
    }
}
