<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sensor;
use App\SensorData;
use App\Venue;
use Faker\Generator as Faker;

$factory->define(Sensor::class, function (Faker $faker) {
    return [
//        'id'=>$faker->randomNumber(2),
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'name' => $faker ->text(5),
        'sensor_type_id' =>$faker ->randomNumber(1),
        'pin_number' =>$faker ->randomNumber(2),


    ];
});
