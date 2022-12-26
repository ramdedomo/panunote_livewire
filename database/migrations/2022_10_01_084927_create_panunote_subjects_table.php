<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_subjects', function (Blueprint $table) {
            $table->integer('subject_id', true);
            $table->integer('user_id')->default(0)->index('FK_panunote_subjects_panunote_users');
            $table->string('subject_name', 50)->default('');
            $table->tinyInteger('subject_sharing')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_subjects');
    }
}
