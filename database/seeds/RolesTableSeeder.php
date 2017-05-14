<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Role::class, 15)->create()->each(function ($role) {
            $role->perms()->sync(\App\Models\Permission::all()->random(rand(1, \App\Models\Permission::count())));
        });
    }
}
