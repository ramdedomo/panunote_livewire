<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanunoteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panunote_users', function (Blueprint $table) {
            $table->integer('user_id')->primary();
            $table->text('user_email')->nullable();
            $table->text('user_fname')->nullable();
            $table->text('user_lname')->nullable();
            $table->text('username')->nullable();
            $table->text('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panunote_users');
    }
}
