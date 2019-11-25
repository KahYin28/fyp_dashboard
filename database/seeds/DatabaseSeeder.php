<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Faculty::class, 10)->create();
        factory(App\User::class, 10)->create();
        factory(App\Student::class, 10)->create();
        factory(App\Venue::class, 10)->create();
        factory(App\Emotion::class, 10)->create();
        factory(App\Lesson::class, 10)->create();
        factory(App\Register::class, 10)->create();
        factory(App\Attendance::class, 10)->create();
        factory(App\Aircon::class, 10)->create();
        factory(App\Lighting::class, 10)->create();
        factory(App\Replacement::class, 10)->create();
    }
}
