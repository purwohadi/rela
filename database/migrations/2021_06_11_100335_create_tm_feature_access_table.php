<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmFeatureAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_feature_access', function (Blueprint $table) {
          $table->increments('i_id')->comment('id, autoincrement');
          $table->string('v_name')->comment('nama feature access');
          $table->string('v_alias')->comment('user alias');
          $table->string('e_type')->comment('tipe feature access (menu, link, crud, filter)');
          $table->integer('i_parentid')->nullable()->comment('id parent, link to tm_feature_access');
          $table->text('v_description')->nullable()->comment('keterangan feature access');
          $table->string('v_route')->nullable()->comment('route feature access');
          $table->string('v_params')->nullable()->comment('parameter feature access');
          $table->string('v_icon', 50)->nullable()->comment('icon menu feature access');
          $table->integer('i_order_no')->nullable()->comment('order number menu');
          $table->dateTime('dt_created_at')->nullable()->comment('waktu input');
          $table->string('v_created_by', 20)->nullable()->comment('user input');
          $table->dateTime('dt_updated_at')->nullable()->comment('waktu update terakhir');
          $table->string('v_updated_by', 20)->nullable()->comment('user update terakhir');

          // $table->foreign('i_parentid')->references('i_id')->on('tm_feature_access')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_feature_access');
    }
}
