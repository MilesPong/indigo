<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Page::class)->create([
            'title' => 'about',
            'slug' => 'about',
            'is_draft' => false,
            'deleted_at' => null
        ]);

        factory(\App\Models\Page::class, 5)->create();
    }
}
