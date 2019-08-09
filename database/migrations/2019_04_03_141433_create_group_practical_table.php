<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPracticalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_practical', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->index()->nullable(true);
            $table->integer('practical_id')->unsigned()->index()->nullable(true);
            $table->boolean('access');

            $table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('practical_id')->references('id')->on('practicals')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_practical');
    }
}
