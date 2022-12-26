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
        Schema::create('lib_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->string('history_desc');
            $table->integer('konsulta_history_id');
            $table->boolean('konsulta_library_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_medical_histories');
    }
};
