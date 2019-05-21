<?php

$factory->define(App\Coursematerial::class, function (Faker\Generator $faker) {
    return [
        "coursename_id" => factory('App\Course')->create(),
        "title" => $faker->name,
        "slug" => $faker->name,
        "description" => $faker->name,
        "position" => $faker->randomNumber(2),
        "freelessons" => 0,
        "published" => 0,
    ];
});
