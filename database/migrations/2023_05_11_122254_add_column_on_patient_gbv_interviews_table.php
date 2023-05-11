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
            $table->boolean('deferred')->nullable()->after('patient_gbv_id');
            $table->foreignId('deferral_reason_id')->nullable()->constrained('lib_gbv_deferral_reasons')->after('deferred');
            $table->foreignId('deferral_previous_interviewer_id')->nullable()->constrained('lib_gbv_previous_interviewers')->after('deferral_reason_id');
            $table->foreignId('deferral_interviewer_remarks')->nullable()->after('deferral_previous_interviewer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('deferred');
            $table->dropColumn('deferral_reason_id');
            $table->dropColumn('deferral_previous_interviewer_id');
            $table->dropColumn('deferral_interviewer_remarks');
        });
    }
};
