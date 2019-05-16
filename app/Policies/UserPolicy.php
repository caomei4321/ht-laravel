<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /*public function before(Admin $admin)
    {
        if ($admin->hasRole('administrator')) {
            return true;
        }
    }*/

    public function own(Admin $admin, User $user)
    {
        return $admin->company_id == $user->company_id;
    }

    public function create(Admin $admin)
    {
        //return $this->company
    }
}
