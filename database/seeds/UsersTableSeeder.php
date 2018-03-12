<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 10)->create()->each(function ($user) {
            $user->roles()->sync(\App\Models\Role::all()->random(rand(1, \App\Models\Role::count())));
        });
    }
}
