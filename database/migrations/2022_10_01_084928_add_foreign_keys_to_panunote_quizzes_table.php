<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_quizzes', function (Blueprint $table) {
            $table->foreign(['note_id'], 'FK_panunote_quizzes_panunote_notes')->references(['note_id'])->on('panunote_notes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_quizzes', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_quizzes_panunote_notes');
        });
    }
}
