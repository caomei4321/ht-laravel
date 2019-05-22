<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Device;
use App\Models\User;
use App\Policies\DepartmentPolicy;
use App\Policies\DevicePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Department::class => DepartmentPolicy::class,
        User::class       => UserPolicy::class,
        Device::class     => DevicePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
