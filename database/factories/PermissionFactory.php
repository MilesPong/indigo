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

$factory->define(\App\Models\Permission::class, function (\Faker\Generator $faker) {
    $name = $faker->unique()->word;
    $displayName = studly_case($name);

    return [
        'name' => 'can-' . $name,
        'display_name' => $displayName,
        'description' => $faker->sentences(2, true)
    ];
});

