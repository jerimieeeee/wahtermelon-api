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
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->boolean('incident_first_unknown')->after('info_source_code')->nullable();
            $table->boolean('incident_recent_unknown')->after('incident_first_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('incident_first_unknown');
            $table->dropColumn('incident_recent_unknown');
        });
    }
};
