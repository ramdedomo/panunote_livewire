<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPanunoteNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panunote_notes', function (Blueprint $table) {
            $table->foreign(['subject_id'], 'FK_panunote_notes_panunote_subjects')->references(['subject_id'])->on('panunote_subjects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panunote_notes', function (Blueprint $table) {
            $table->dropForeign('FK_panunote_notes_panunote_subjects');
        });
    }
}
