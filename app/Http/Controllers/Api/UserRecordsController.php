<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserRecordsController extends Controller
{
    public function records(User $user)
    {
        $users = $user->find($this->user());
        return $users->user_records();
    }
}
