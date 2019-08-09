<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practical_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('practical_id')->unsigned()->index()->nullable(true);
            $table->integer('user_id')->unsigned()->index()->nullable(true);
            $table->integer('score_id')->unsigned()->index()->nullable(true);

            $table->foreign('practical_id')->references('id')->on('practicals')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('score_id')->references('id')->on('scores')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practical_user');
    }
}
