<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteSubjectlikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_subjectlikes', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->index('FK_panunote_subjectlikes_panunote_users');
            $table->integer('subject_id')->nullable()->index('FK_panunote_subjectlikes_panunote_subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_subjectlikes');
    }
}
