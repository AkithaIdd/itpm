<?php

$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        "coursename" => $faker->name,
        "description" => $faker->name,
        "price" => $faker->randomNumber(2),
        "startdate" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "published" => 0,
    ];
});
