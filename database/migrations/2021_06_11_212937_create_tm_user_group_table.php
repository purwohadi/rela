<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_user_group', function (Blueprint $table) {
            $table->increments('i_id')->comment('id, autoincrement');
            // $table->string('v_userid', 20)->references('v_userid')->on('tm_user')->onDelete('cascade');
            $table->string('v_userid')->comment('id user');
            $table->integer('v_group_id')->unsigned()->comment('id group');
            $table->dateTime('dt_created_at')->nullable()->comment('waktu input');
            $table->string('v_created_by', 20)->nullable()->comment('user input');

            $table->foreign('v_userid')->references('v_userid')->on('tm_users')->onDelete('cascade');
            $table->foreign('v_group_id')->references('i_id')->on('tm_group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_user_group');
    }
}
