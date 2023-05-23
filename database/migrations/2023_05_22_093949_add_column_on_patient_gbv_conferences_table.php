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
        Schema::table('patient_gbv_conferences', function (Blueprint $table) {
            $table->string('conference_invitee_remarks')->after('notes')->nullable();
            $table->string('conference_concern_remarks')->after('conference_invitee_remarks')->nullable();
            $table->string('conference_mitigating_factor_remarks')->after('conference_concern_remarks')->nullable();
            $table->string('conference_recommendation_remarks')->after('conference_mitigating_factor_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_conferences', function (Blueprint $table) {
            $table->dropColumn('conference_invitee_remarks');
            $table->dropColumn('conference_concern_remarks');
            $table->dropColumn('conference_mitigating_factor_remarks');
            $table->dropColumn('conference_recommendation_remarks');
        });
    }
};
