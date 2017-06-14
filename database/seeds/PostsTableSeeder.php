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
        factory(\App\Models\Post::class, 30)->create()->each(function (\App\Models\Post $post) {
            $tagCount = \App\Models\Tag::count();
            $post->tags()->sync(\App\Models\Tag::inRandomOrder()->take(mt_rand(1, 4))->get());
            // $post->tags()->attach(App\Models\Tag::all()->random(rand(1, App\Models\Tag::count())));
        });
    }
}
