<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Setting::class, function (Faker $faker) {
    $key = $faker->unique()->word;

    return [
        'key' => $key,
        'value' => $faker->sentence(mt_rand(3, 6)),
        'tag' => $key,
    ];
});
