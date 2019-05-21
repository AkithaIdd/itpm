<?php

$factory->define(App\Assignment::class, function (Faker\Generator $faker) {
    return [
        "coursename_id" => factory('App\Course')->create(),
        "assignmenttitle" => $faker->name,
        "question" => $faker->name,
        "submittion" => $faker->name,
    ];
});
