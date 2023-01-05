<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lib_laboratories', function (Blueprint $table) {
            $table->char('code',10)->index()->primary();
            $table->string('desc')->index();
            $table->boolean('lab_active')->default(0);
            $table->boolean('konsulta_active')->default(0);
            $table->unsignedInteger('konsulta_lab_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_laboratories');
    }
};
