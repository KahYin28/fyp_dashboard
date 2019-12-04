<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->double('happy');
            $table->double('sad');
            $table->double('angry');
            $table->double('confused');
            $table->double('disgusted');
            $table->double('surprised');
            $table->double('calm');
            $table->double('fear');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emotions');
    }
}
