<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteQuizlikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_quizlikes', function (Blueprint $table) {
            $table->foreign(['quiz_id'], 'FK_panunote_quizlikes_panunote_quizzes')->references(['quiz_id'])->on('panunote_quizzes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'FK_panunote_quizlikes_panunote_users')->references(['user_id'])->on('panunote_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_quizlikes', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_quizlikes_panunote_quizzes');
            $table->dropForeign('FK_panunote_quizlikes_panunote_users');
        });
    }
}
