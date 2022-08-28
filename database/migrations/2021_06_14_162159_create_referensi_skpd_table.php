<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferensiSkpdTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $tableName = config('tables.reference.skpd');
    if (Schema::hasTable($tableName)) return;
    Schema::create($tableName, function (Blueprint $table) {
      $table->string('v_kode_skpd', 9)->primary()->comment('Kode Lokasi');
      $table->string('v_nama_skpd', 300)->comment('Nama PD/UKPD');
      $table->string('v_unit_id', 8)->comment('Kode Sipkd');
      $table->enum('e_bidang', [1, 2, 3, 4, 5])->nullable()->comment('Bidang Asisten: 1, 2, 3, 4, 5');
      $table->enum('e_is_induk', [0, 1])->nullable()->comment('Bidang Asisten: 0, 1');
      $table->string('v_tahun_awal', 4)->nullable()->comment('Tahun Awal Berlaku');
      $table->string('v_tahun_akhir', 4)->nullable()->comment('Tahun Akhir Berlaku');
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
    $tableName = config('tables.reference.skpd');
    Schema::dropIfExists($tableName);
  }
}
