<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Admin::class, 1)->create([
            'name' => 'cm',
            'email' => 'admin',
            'password' => bcrypt('admin')
        ]);
        $administrator = Admin::find(1);
        $administrator->assignRole('administrator');
    }
}
