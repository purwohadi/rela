<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlAuditTrailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_audit_trail', function (Blueprint $table) {
          $table->increments('i_id')->comment('id, autoincrement');
          $table->string('v_user_aksi', 20)->comment('user pelaku aksi');
          $table->string('v_ip_user', 30)->comment('ip client yang digunakan user');
          $table->dateTime('dt_waktu_aksi')->comment('waktu dilakukan aksi');
          $table->enum('e_jenis_aksi', ['INS', 'UPD', 'DEL'])->comment('INS, UPD, DEL');
          $table->string('v_nama_tabel', 100)->comment('nama tabel yang diupdate datanya');
          $table->text('tx_data')->comment('data update dalam JSON');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tl_audit_trail');
    }
}
