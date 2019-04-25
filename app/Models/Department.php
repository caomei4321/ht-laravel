<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['department_name', 'license'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
