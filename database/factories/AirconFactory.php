<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aircon;
use App\Venue;
use Faker\Generator as Faker;

$factory->define(Aircon::class, function (Faker $faker) {
    return [
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'set_point' => $faker->numberBetween(16, 32)
    ];
});
