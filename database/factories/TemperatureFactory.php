<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Temperature;
use App\Venue;
use Faker\Generator as Faker;

$factory->define(Temperature::class, function (Faker $faker) {
    return [
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'value' => $faker->numberBetween(16, 32)

    ];
});
