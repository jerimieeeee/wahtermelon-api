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
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->date('gbv_date')->after('facility_code');
            $table->string('gbv_complaint_remarks')->after('gbv_date')->nullable();
            $table->string('gbv_behavioral_remarks')->after('gbv_complaint_remarks')->nullable();
            $table->string('gbv_neglect_remarks')->after('gbv_behavioral_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->dropColumn('gbv_date');
            $table->dropColumn('gbv_complaint_remarks');
            $table->dropColumn('gbv_behavioral_remarks');
            $table->dropColumn('gbv_neglect_remarks');
        });
    }
};
