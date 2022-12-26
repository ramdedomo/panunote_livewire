<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteQuizlikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_quizlikes', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->index('FK_panunote_quizlikes_panunote_users');
            $table->integer('quiz_id')->nullable()->index('FK_panunote_quizlikes_panunote_quizzes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_quizlikes');
    }
}
