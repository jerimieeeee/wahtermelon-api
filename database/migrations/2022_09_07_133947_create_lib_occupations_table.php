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
        Schema::create('lib_occupations', function (Blueprint $table) {
            $table->char('occupation_code',10)->primary();
            $table->char('category_code', 10)->index();
            $table->string('occupation_desc', 100);
            $table->foreign('category_code')->references('category_code')->on('lib_occupation_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_occupations');
    }
};
