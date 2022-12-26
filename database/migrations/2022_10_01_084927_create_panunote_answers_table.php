<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_answers', function (Blueprint $table) {
            $table->integer('answer_id', true);
            $table->integer('question_id')->nullable()->index('FK_panunote_answers_panunote_questions');
            $table->tinyInteger('is_correct')->default(0);
            $table->text('answer_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_answers');
    }
}
