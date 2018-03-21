<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Post::class, 30)->create()->each(function ($post) {
            /** @var \App\Models\Post $post */
            $post->tags()->sync(\App\Models\Tag::inRandomOrder()->take(mt_rand(1, 4))->pluck('id'));
        });
    }
}
