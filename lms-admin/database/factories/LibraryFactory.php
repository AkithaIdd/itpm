<?php

$factory->define(App\Library::class, function (Faker\Generator $faker) {
    return [
        "coursename_id" => factory('App\Course')->create(),
    ];
});
