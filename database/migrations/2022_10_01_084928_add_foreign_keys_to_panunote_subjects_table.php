<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_subjects', function (Blueprint $table) {
            $table->foreign(['user_id'], 'FK_panunote_subjects_panunote_users')->references(['user_id'])->on('panunote_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_subjects', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_subjects_panunote_users');
        });
    }
}
