<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\Register;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Register::class, function (Faker $faker) {
    return [
       // 'id'=>$faker->randomNumber(3),
        'student_id' => $faker->numberBetween(Student::all()->first()->student_id, Student::all()->last()->student_id),
        'lesson_id' => $faker->numberBetween(Lesson::all()->first()->id, Lesson::all()->last()->id),
    ];
});
