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
            $table->dateTime('interview_datetime')->after('facility_code')->nullable();
            $table->boolean('recant_flag')->after('interview_datetime')->nullable();
            $table->dateTime('recant_datetime')->after('recant_flag')->nullable();
            $table->string('recant_remarks')->after('recant_datetime')->nullable();
            $table->dateTime('deferral_datetime')->after('deferred')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('interview_datetime');
            $table->dropColumn('recant_flag');
            $table->dropColumn('recant_datetime');
            $table->dropColumn('recant_remarks');
            $table->dropColumn('deferral_datetime');
        });
    }
};
