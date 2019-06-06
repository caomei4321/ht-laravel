<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'id', 'plateid', 'license', 'colorType', 'type', 'colorValue', 'carColor', 'enable', 'need_alarm', 'enable_time', 'overdue_time'
    ];
}
