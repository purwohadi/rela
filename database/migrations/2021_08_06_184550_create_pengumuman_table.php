<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $tableName = config('tables.master.pengumuman');
      if (Schema::hasTable($tableName)) return;
      Schema::create($tableName, function (Blueprint $table) {
        $table->bigIncrements('i_id')->comment('ID, auto increment');
        $table->bigInteger('e_kat_pengumuman')->comment('Info Depan, Banner');
        $table->text('tx_isi_pengumuman')->comment('Isi pengumuman');
        $table->string('e_status_aktif', 1)->comment('1/0');
        $table->boolean('e_highlight', 1)->default(false)->comment('1/0');

        $table->string('v_created_by', 20)->nullable()->comment('User Input');
        $table->timestamp('dt_created_at')->nullable()->comment('Waktu Input');
        $table->string('v_updated_by', 20)->nullable()->comment('User Update');
        $table->timestamp('dt_updated_at')->nullable()->comment('Waktu Update');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      $tableName = config('tables.master.pengumuman');
      Schema::dropIfExists($tableName);
    }
}
