<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_answers', function (Blueprint $table) {
            $table->foreign(['question_id'], 'FK_panunote_answers_panunote_questions')->references(['question_id'])->on('panunote_questions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_answers', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_answers_panunote_questions');
        });
    }
}
