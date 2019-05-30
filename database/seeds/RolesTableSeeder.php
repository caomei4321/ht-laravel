<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'administrator',
            'guard_name' => 'admin',
        ]);
        DB::table('roles')->insert([
            'name' => 'company_manage',
            'guard_name' => 'admin',
        ]);
    }
}
