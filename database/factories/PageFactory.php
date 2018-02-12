<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Page::class, function (Faker $faker) {
    $title = $faker->unique()->sentence(mt_rand(3, 6));

    return [
        'title' => $title,
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'description' => $faker->sentence(10),
        'slug' => str_slug($title),
        'content_id' => function () {
            return factory(\App\Models\Content::class)->create()->id;
        },
        'view_count' => mt_rand(0, 10000),
        'is_draft' => $faker->boolean,
        'deleted_at' => $faker->optional(0.3)->dateTime()
    ];
});
