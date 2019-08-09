<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text', 1000);
            $table->integer('parent')->unsigned();
            $table->integer('practical_id')->unsigned()->index()->nullable(true);
            $table->integer('user_id')->unsigned()->index()->nullable(true);
            $table->timestamps();

            $table->foreign('practical_id')->references('id')->on('practicals')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
