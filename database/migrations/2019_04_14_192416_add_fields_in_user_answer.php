<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInUserAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned()->index()->nullable(true);
            $table->integer('question_id')->unsigned()->index()->nullable(true);

            $table->foreign('task_id')->references('id')->on('tasks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_answer', function (Blueprint $table) {
            $table->dropColumn('task_id');
            $table->dropColumn('question_id');
            $table->dropColumn('id');
        });
    }
}
