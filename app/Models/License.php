<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'id', 'plateid', 'license', 'colorType', 'type', 'colorValue', 'carColor', 'enable', 'need_alarm', 'enable_time', 'overdue_time'
    ];

}