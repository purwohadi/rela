<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmFeatureAccessGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_feature_access_group', function (Blueprint $table) {
          $table->increments('i_id')->comment('id, autoincrement');
          $table->integer('i_group_id')->unsigned()->comment('id grup');
          $table->integer('i_feature_id')->unsigned()->comment('id tm_feature_access');
          $table->dateTime('dt_created_at')->nullable()->comment('waktu input');
          $table->string('v_created_by', 20)->nullable()->comment('user input');

          $table->foreign('i_group_id')->references('i_id')->on('tm_group')->onDelete('cascade');
          $table->foreign('i_feature_id')->references('i_id')->on('tm_feature_access')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_feature_access_group');
    }
}
