<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    $title = $faker->unique()->sentence(mt_rand(3, 6));

    return [
        'title' => $title,
        'user_id' => App\Models\User::inRandomOrder()->first()->id,
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
        'description' => $faker->sentence(10),
        'slug' => str_slug($title),
        'feature_img' => random_img_url(),
        'content_id' => function () {
            return factory(\App\Models\Content::class)->create()->id;
        },
        'view_count' => mt_rand(0, 10000),
        'is_draft' => $faker->boolean,
        'published_at' => $faker->dateTimeThisYear('2018-12-31 23:59:59'),
        'deleted_at' => $faker->optional(0.3)->dateTime(),
    ];
});
