<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function users(User $user)
    {
        $users = $user->all();
        return $this->response->array([
            'data' => $users,
            'success' => 1
        ]);
    }

    public function userRecord(Request $request)
    {

    }
}
