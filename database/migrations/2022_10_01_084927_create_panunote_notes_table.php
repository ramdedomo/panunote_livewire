<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_notes', function (Blueprint $table) {
            $table->integer('note_id', true);
            $table->integer('subject_id')->default(0)->index('FK_panunote_notes_panunote_subjects');
            $table->mediumText('note_content');
            $table->tinyInteger('note_sharing')->default(0);
            $table->text('note_tags');
            $table->text('note_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_notes');
    }
}
