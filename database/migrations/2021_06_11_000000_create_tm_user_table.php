<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $tableName = config('tables.master.users');
    Schema::create($tableName, function (Blueprint $table) {
      $table->string('v_userid', 20)->unique()->primary()->comment('id user');
      $table->string('v_userpass', 100)->comment('encrypted user password');
      $table->string('v_username', 100)->comment('nama user');
      $table->enum('e_user_enable', ['1', '0'])->comment('1, 0');
      $table->timestamp('d_last_logged_in')->nullable()->comment('waktu terakhir login');
      $table->date('d_last_update_pass')->nullable()->comment('tanggal terakhir ganti password');
      $table->dateTime('dt_created_at')->nullable()->comment('waktu input');
      $table->string('v_created_by', 20)->nullable()->comment('user input');
      $table->dateTime('dt_updated_at')->nullable()->comment('waktu update terakhir');
      $table->string('v_updated_by', 20)->nullable()->comment('user update terakhir');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $tableName = config('tables.master.users');
    Schema::dropIfExists($tableName);
  }
}
