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
        $permissionCount = \App\Models\Permission::count();

        factory(\App\Models\Role::class, 15)->create()->each(function ($role) use ($permissionCount) {
            /** @var \App\Models\Role $role */
            $role->perms()->sync(\App\Models\Permission::inRandomOrder()->take(mt_rand(1,
                $permissionCount))->pluck('id'));
        });
    }
}
