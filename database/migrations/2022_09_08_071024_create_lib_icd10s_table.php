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
        Schema::create('lib_icd10s', function (Blueprint $table) {
            $table->string('icd10_code', 50)->primary();
            $table->string('icd10_desc', 255);
            $table->integer('notifiable_cat')->nullable();
            $table->string('notifiable_name', 100)->nullable();
            $table->boolean('is_morbidity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_icd10s');
    }
};
