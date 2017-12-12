<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\Role::class, function (\Faker\Generator $faker) {
    $name = $faker->unique()->word;
    $displayName = studly_case($name);

    return [
        'name' => $name,
        'display_name' => $displayName,
        'description' => $faker->sentences(2, true)
    ];
});

$factory->define(\App\Models\Permission::class, function (\Faker\Generator $faker) {
    $name = $faker->unique()->word;
    $displayName = studly_case($name);

    return [
        'name' => 'can-' . $name,
        'display_name' => $displayName,
        'description' => $faker->sentences(2, true)
    ];
});

$factory->define(\App\Models\Category::class, function (\Faker\Generator $faker) {
    $name = $faker->unique()->sentence(2);

    return [
        'name' => $name,
        'description' => $faker->sentence(),
        'slug' => str_slug($name),
    ];
});

$factory->define(\App\Models\Tag::class, function (\Faker\Generator $faker) {
    $name = $faker->unique()->word;

    return [
        'name' => $name,
        'description' => $faker->sentence(),
        'slug' => str_slug($name)
    ];
});

$factory->define(\App\Models\Content::class, function (\Faker\Generator $faker) {
    return [
        'body' => markdownContent($faker)
    ];
});

$factory->define(\App\Models\Post::class, function (\Faker\Generator $faker) {
    $title = $faker->unique()->sentence(mt_rand(3, 6));

    return [
        'title' => $title,
        'user_id' => App\Models\User::inRandomOrder()->first()->id,
        'category_id' => \App\Models\Category::pluck('id')->random(),
        'description' => $faker->sentence(10),
        'slug' => str_slug($title),
        'excerpt' => $faker->sentences(3, true),
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