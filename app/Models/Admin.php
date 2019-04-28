<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'email', 'password', 'company_name', 'working_at', 'end_at'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
