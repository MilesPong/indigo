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

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(2);

    return [
        'name' => $name,
        'description' => $faker->sentence(),
        'slug' => str_slug($name),
    ];
});

