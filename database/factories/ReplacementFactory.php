<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Replacement;
use App\User;
use App\Venue;
use App\Lesson;
use Carbon\Carbon;
use Faker\Generator as Faker;


$factory->define(Replacement::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(User::all()->first()->id, User::all()->last()->id),
        'lesson_id' =>$faker -> numberBetween(Lesson::all()->first()->id, Lesson::all()->last()->id),
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'starting_date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
        'ending_date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
        'schedule_day' => $faker->dayOfWeek,
        'status'=>$faker->boolean,
    ];
});
