<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Lesson;
use App\User;
use App\Venue;
use Carbon\Carbon;
use Faker\Generator as Faker;


$factory->define(Lesson::class, function (Faker $faker) {
    return [
//        'id'=>$faker->randomNumber(6),
        'user_id' => $faker->numberBetween(User::all()->first()->id, User::all()->last()->id),
        'venue_id' => $faker->numberBetween(Venue::all()->first()->id, Venue::all()->last()->id),
        'starting_date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
        'ending_date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
        'schedule_day' => $faker->dayOfWeek,
        'course_code' => $faker->bothify('???####'),
        'course_name' => $faker->text(10),
        'group' => $faker->numberBetween(1, 10),
        'lesson_type_id' => $faker->numberBetween(1, 3),
        'semester' => $faker->numberBetween(16, 20) . $faker->numberBetween(17, 21) . $faker->numberBetween(1, 3),
    ];
});
