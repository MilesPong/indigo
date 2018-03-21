<?php

use Illuminate\Database\Seeder;

class InitializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->create([
            'name' => 'Miles Peng',
            'email' => 'mingpeng16@gmail.com',
            'password' => bcrypt('indigo')
        ]);

        factory(\App\Models\Category::class)->create([
            'name' => 'Uncategorized',
            'description' => 'Default category',
            'slug' => 'uncategorized'
        ]);

        factory(\App\Models\Page::class)->create([
            'title' => 'About',
            'slug' => 'about',
            'description' => null,
            'content_id' => factory(\App\Models\Content::class)->create([
                'body' => "## This is the about page."
            ])->id,
            'view_count' => 0,
            'is_draft' => false,
            'deleted_at' => null
        ]);

        factory(\App\Models\Page::class)->create([
            'title' => 'Links',
            'slug' => 'links',
            'description' => null,
            'content_id' => factory(\App\Models\Content::class)->create([
                'body' => "## This is the links page."
            ])->id,
            'view_count' => 0,
            'is_draft' => false,
            'deleted_at' => null
        ]);

        factory(\App\Models\Setting::class)->create([
            'key' => 'title',
            'value' => "Miles' Blog",
            'tag' => 'website'
        ]);

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

        factory(\App\Models\Setting::class)->create([
            'key' => 'heading',
            'value' => 'Just Keep Learning',
            'tag' => 'website'
        ]);
    }
}
