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
        Schema::create('lib_mc_risk_factors', function (Blueprint $table) {
            $table->id();
            $table->string('risk_name');
            $table->boolean('hospital_flag');
            $table->boolean('monitor_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_mc_risk_factors');
    }
};
