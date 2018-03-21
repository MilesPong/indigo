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
        $roleCount = \App\Models\Role::count();

        factory(\App\Models\User::class, 10)->create()->each(function ($user) use ($roleCount) {
            /** @var \App\Models\User $user */
            $user->roles()->sync(\App\Models\Role::inRandomOrder()->take(mt_rand(1, $roleCount))->pluck('id'));
        });
    }
}
