<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('recipient_name');
            $table->string('recipient_email', 255);
            $table->string('title', 255);
            $table->string('summary', 2048);
            $table->string('body', 8192);
            $table->string('thanks_msg', 8192);
            $table->string('picture_path', 2048);
            $table->tinyInteger('private');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petitions', function (Blueprint $table) {
            Schema::drop('petitions');
        });
    }
}
