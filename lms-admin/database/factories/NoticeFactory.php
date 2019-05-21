<?php

$factory->define(App\Notice::class, function (Faker\Generator $faker) {
    return [
        "posision" => $faker->randomNumber(2),
        "title" => $faker->name,
        "body" => $faker->name,
    ];
});
