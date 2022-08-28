<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferensiUmumTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $tableName = config('tables.reference.referensi_umum');
    if (Schema::hasTable($tableName)) return;
    Schema::create($tableName, function (Blueprint $table) {
      $table->bigIncrements('i_id')->comment('ID Referensi, auto increment');
      $table->string('v_key')->comment('Kata Kunci Referensi');
      $table->string('v_value')->comment('Nilai Referensi');
      $table->string('v_reserve')->nullable()->comment('Reservasi Referensi');
      $table->string('v_type')->nullable()->comment('Tipe Referensi');
      $table->enum('e_aktif', [0,1])->default(1)->comment('Flag Aktif Referensi');

      $table->string('v_created_by', 20)->nullable()->comment('User Input');
      $table->timestamp('dt_created_at')->nullable()->comment('Waktu Input');
      $table->string('v_updated_by', 20)->nullable()->comment('User Update');
      $table->timestamp('dt_updated_at')->nullable()->comment('Waktu Update');

      $table->index(['v_key', 'v_type']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $tableName = config('tables.reference.referensi_umum');
    Schema::dropIfExists($tableName);
  }
}
