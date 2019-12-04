<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Emotion;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Emotion::class, function (Faker $faker) {
    return [
        'student_id' => $faker->numberBetween(Student::all()->first()->student_id, Student::all()->last()->student_id),
        'happy' => $faker->randomFloat(2, 0, 100),
        'sad' => $faker->randomFloat(2, 0, 100),
        'angry' => $faker->randomFloat(2, 0, 100),
        'confused' => $faker->randomFloat(2, 0, 100),
        'disgusted' => $faker->randomFloat(2, 0, 100),
        'surprised' => $faker->randomFloat(2, 0, 100),
        'calm' => $faker->randomFloat(2, 0, 100),
        'fear' => $faker->randomFloat(2, 0, 100),
    ];
});
