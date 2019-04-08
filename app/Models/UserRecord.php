<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRecords extends Model
{
    protected $fillable = [
        'user_id', 'job_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
