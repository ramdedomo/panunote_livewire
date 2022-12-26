<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_quizzes', function (Blueprint $table) {
            $table->integer('quiz_id', true);
            $table->integer('note_id')->nullable()->index('FK_panunote_quizzes_panunote_notes');
            $table->tinyInteger('quiz_sharing')->nullable();
            $table->text('quiz_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_quizzes');
    }
}
