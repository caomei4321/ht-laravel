<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['department_name', 'license', 'company_id', 'working_at', 'end_at'];

    public function user()
    {
        return $this->hasMany(User::class,'department_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
