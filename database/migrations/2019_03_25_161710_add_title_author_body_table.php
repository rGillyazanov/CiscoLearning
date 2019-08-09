<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleAuthorBodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practicals', function (Blueprint $table) {
            $table->text('body')->after('description');
            $table->integer('user_id')->unsigned()->index()->after("image")->nullable(true);
        });

        Schema::table('practicals', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practicals', function (Blueprint $table) {
            $table->dropColumn("body");
            $table->dropColumn("user_id");
        });
    }
}
