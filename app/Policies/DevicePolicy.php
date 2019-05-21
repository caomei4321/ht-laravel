<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    public function before(Admin $admin)
    {
        if ($admin->hasRole('administrator')) {
            return true;
        }
    }

    public function own( Admin $admin, Device $device)
    {
        return $admin->company_id == $device->company_id;
    }
}
