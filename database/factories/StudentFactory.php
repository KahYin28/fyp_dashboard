<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Faculty;
use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'student_id' => $faker->numberBetween(188000,189000),
        'faculty_id' => $faker->numberBetween(Faculty::all()->first()->id, Faculty::all()->last()->id),
        'programme' => $faker->text(20),
        'name' => $faker->text(10),
     ];
});
