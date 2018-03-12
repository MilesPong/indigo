<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InitializationSeeder::class);

        if (app()->environment('local')) {
            $this->call(PermissionsTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(TagsTableSeeder::class);
            $this->call(PostsTableSeeder::class);
            $this->call(PagesTableSeeder::class);
            $this->call(SettingsTableSeeder::class);
        }
    }
}
