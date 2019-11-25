<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use App\Register;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    return [
        'register_id' => $faker->unique()->numberBetween(Register::all()->first()->id, Register::all()->last()->id),
        'starting_date_time' => $faker->dateTime,
        'ending_date_time' => $faker->dateTime,
    ];
});
