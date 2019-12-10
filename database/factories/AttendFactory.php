<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use App\Lesson;
use App\Register;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    return [
        'lesson_id' => $faker->unique()->numberBetween(Lesson::all()->first()->id, Lesson::all()->last()->id),
        'student_id' => $faker->numberBetween(Student::all()->first()->student_id, Student::all()->last()->student_id),
        'starting_date_time' => $faker->dateTime,
        'ending_date_time' => $faker->dateTime,
        'status'=> $faker->boolean
    ];
});
