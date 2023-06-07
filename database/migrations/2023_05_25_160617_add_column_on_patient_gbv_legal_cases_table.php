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
        Schema::table('patient_gbv_legal_cases', function (Blueprint $table) {
            $table->boolean('blotter_filed_flag')->after('patient_gbv_intake_id')->nullable();
            $table->string('blotter_remarks')->after('blotter_filed_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_legal_cases', function (Blueprint $table) {
            $table->dropColumn('blotter_filed_flag');
            $table->dropColumn('blotter_remarks');
        });
    }
};
