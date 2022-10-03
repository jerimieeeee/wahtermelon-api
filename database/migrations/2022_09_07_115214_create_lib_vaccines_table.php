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
        Schema::create('lib_vaccines', function (Blueprint $table) {
            $table->string('vaccine_id', 25)->primary();
            $table->string('vaccine_name', 50);
            $table->integer('vaccine_interval');
            $table->string('vaccine_module', 12);
            $table->string('vaccine_desc', 255);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_vaccines');
    }
};
