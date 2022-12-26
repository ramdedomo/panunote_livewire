<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteSubjectlikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_subjectlikes', function (Blueprint $table) {
            $table->foreign(['subject_id'], 'FK_panunote_subjectlikes_panunote_subjects')->references(['subject_id'])->on('panunote_subjects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'FK_panunote_subjectlikes_panunote_users')->references(['user_id'])->on('panunote_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_subjectlikes', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_subjectlikes_panunote_subjects');
            $table->dropForeign('FK_panunote_subjectlikes_panunote_users');
        });
    }
}
