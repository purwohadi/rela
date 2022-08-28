<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('tables.master.menu');
        Schema::create($tableName, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('group')->nullable();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('tags')->nullable();
            $table->string('route')->nullable();
            $table->string('parent', 36)->nullable();
            $table->integer('order_no')->default(0);
            $table->string('permission_id', 36)->nullable();
            $table->tinyInteger('visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['label', 'parent', 'tags']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('tables.master.menu');
        Schema::dropIfExists($tableName);
    }
}
