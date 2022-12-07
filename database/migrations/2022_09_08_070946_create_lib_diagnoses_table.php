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
        Schema::create('lib_diagnoses', function (Blueprint $table) {
            $table->integer('class_id')->primary();
            $table->string('class_name', 255);
            $table->string('icd10', 20);
            $table->boolean('notifiable_flag');
            $table->boolean('morbidity_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_diagnoses');
    }
};
