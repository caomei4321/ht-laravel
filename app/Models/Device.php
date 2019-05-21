<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_no', 'remark', 'company_id'
    ];

    public function htData()
    {
        return $this->hasMany(HtData::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class,'device_user');
    }
}
