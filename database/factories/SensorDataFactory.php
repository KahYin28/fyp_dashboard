<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sensor;
use App\SensorData;
use App\Venue;
use Faker\Generator as Faker;

$factory->define(SensorData::class, function (Faker $faker) {
    return [

        'sensor_id' => $faker->numberBetween(Sensor::all()->first()->id, Sensor::all()->last()->id),
        'field' => $faker->text(5),
        'value' => $faker->numberBetween(22, 32),


    ];
});
