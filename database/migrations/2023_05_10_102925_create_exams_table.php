<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->bigInteger('question_type_id');
            $table->text('question');
            $table->longText('options');
            $table->text('correct_answer');
            $table->integer('default_marks');
            $table->integer('default_time');
            $table->text('solution');
            $table->longText('solution_video_url');
            $table->text('hint');
            $table->tinyInteger('is_active');
            $table->longText('ans_weight');
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
        Schema::dropIfExists('exams');
    }
}
