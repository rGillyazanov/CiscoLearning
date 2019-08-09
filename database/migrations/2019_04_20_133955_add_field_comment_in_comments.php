<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCommentInComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('practical_user_id')->unsigned()->index()->nullable(true);
            $table->integer('theory_id')->unsigned()->index()->nullable(true);

            $table->foreign('practical_user_id')->references('id')->on('practical_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('theory_id')->references('id')->on('theories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('practical_user_id');
            $table->dropColumn('theory_id');
        });
    }
}
