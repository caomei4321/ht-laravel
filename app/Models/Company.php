<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
//    protected $table = 'companies';
    protected $fillable = ['company_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
