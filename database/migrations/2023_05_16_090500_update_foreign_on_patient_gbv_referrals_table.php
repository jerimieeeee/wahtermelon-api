<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient_gbv_referrals', function (Blueprint $table) {
            $table->dropForeign(['patient_gbv_id']);
            $table->foreign('patient_gbv_id')->references('id')->on('patient_gbvs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_referrals', function (Blueprint $table) {
            $table->dropForeign(['patient_gbv_id']);
            $table->foreign('patient_gbv_id')->references('id')->on('patient_gbv_intakes');
        });
    }
};
