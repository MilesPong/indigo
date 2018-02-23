<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Setting::class)->create([
            'key' => 'keywords',
            'value' => 'miles,milespong,laravel,blog',
            'tag' => 'seo'
        ]);

        factory(\App\Models\Setting::class)->create([
            'key' => 'description',
            'value' => 'A blog built with laravel by Miles',
            'tag' => 'seo'
        ]);

        factory(\App\Models\Setting::class, 5)->create();
    }
}
