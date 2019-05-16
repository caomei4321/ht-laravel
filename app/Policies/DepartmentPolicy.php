<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function before(Admin $admin)
    {
        if ($admin->hasRole('administrator')) {
            return true;
        }
    }

    public function own(Admin $admin, Department $department)
    {
        return $admin->company_id == $department->company_id;
    }
}
