<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_group', function (Blueprint $table) {
          $table->increments('i_id')->comment('id, autoincrement');
          $table->string('v_group_name', 50)->comment('Nama grup');
          $table->enum('e_status_aktif', [1,0])->comment('1/0');
          $table->dateTime('dt_created_at')->nullable()->comment('waktu input');
          $table->string('v_created_by', 20)->nullable()->comment('user input');
          $table->dateTime('dt_updated_at')->nullable()->comment('waktu update terakhir');
          $table->string('v_updated_by', 20)->nullable()->comment('user update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_group');
    }
}
