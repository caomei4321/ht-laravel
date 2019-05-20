<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需要先清除缓存，否则报错
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //创建角色
        Role::create(['name' => 'administrator', 'guard_name' => 'admin']);
        Role::create(['name' => 'company_manage', 'guard_name' => 'admin']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
