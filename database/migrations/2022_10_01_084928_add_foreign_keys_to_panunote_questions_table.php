<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_questions', function (Blueprint $table) {
            $table->foreign(['quiz_id'], 'FK_panunote_questions_panunote_quizzes')->references(['quiz_id'])->on('panunote_quizzes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_questions', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_questions_panunote_quizzes');
        });
    }
}
