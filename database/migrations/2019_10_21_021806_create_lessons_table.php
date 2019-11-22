<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('venue_id')->nullable();
            $table->dateTime('starting_date_time');
            $table->dateTime('ending_date_time');
            $table->string('schedule_day')->nullable();
            $table->string('course_code');
            $table->integer('group')->nullable();
            $table->integer('lesson_type_id');
            $table->integer('semester');
            $table->timestamps();
            $table->unique(['starting_date_time','ending_date_time','schedule_day', 'course_code', 'group', 'lesson_type_id', 'semester'],'unique_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
