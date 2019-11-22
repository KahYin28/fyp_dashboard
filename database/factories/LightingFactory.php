<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lighting;
use App\Venue;
use Faker\Generator as Faker;

$factory->define(Lighting::class, function (Faker $faker) {
    return [
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'on_off' => $faker->boolean
    ];
});
