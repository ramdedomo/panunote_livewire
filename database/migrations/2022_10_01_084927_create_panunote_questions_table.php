<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_questions', function (Blueprint $table) {
            $table->integer('question_id', true);
            $table->integer('quiz_id')->nullable()->index('FK_panunote_questions_panunote_quizzes');
            $table->text('question_text')->nullable();
            $table->tinyInteger('question_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_questions');
    }
}
