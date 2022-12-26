<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteNotelikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_notelikes', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->index('FK_panunote_notelikes_panunote_users');
            $table->integer('note_id')->nullable()->index('FK_panunote_notelikes_panunote_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_notelikes');
    }
}
