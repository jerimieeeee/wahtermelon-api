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
        Schema::create('consult_mc_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mc_id')->constrained('mcs');
            // $table->foreignId('consult_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('risk_id')->constrained('lib_mc_risk_factors');
            $table->date('date_detected')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_mc_risks');
    }
};
