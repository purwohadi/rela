<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('tables.reference.references');
        Schema::create($tableName, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key');
            $table->string('value');
            $table->string('type');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['key', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('tables.reference.references');
        Schema::dropIfExists($tableName);
    }
}
