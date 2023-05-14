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
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });

        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });

        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });

        Schema::table('patient_gbv_interview_dev_screenings', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_emotional_abuses', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_neglect_abuses', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_perpetrators', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_physical_abuses', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_sexual_abuses', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_interview_summaries', function (Blueprint $table) {
            $table->char('intake_id', 26)->after('facility_code');
            $table->foreign('intake_id')->references('id')->on('patient_gbv_intakes');
        });

        Schema::table('patient_gbv_placements', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });

        Schema::table('patient_gbv_psychs', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });

        Schema::table('patient_gbv_social_works', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_conferences', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_conferences_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_family_compositions_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interviews_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_interview_dev_screenings', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_dev_screenings_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_emotional_abuses', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_emotional_abuses_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_neglect_abuses', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_neglect_abuses_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_perpetrators', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_perpetrators_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_physical_abuses', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_physical_abuses_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_sexual_abuses', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_sexual_abuses_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_interview_summaries', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_interview_summaries_intake_id_foreign');
            $table->dropColumn('intake_id');
        });

        Schema::table('patient_gbv_placements', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_placements_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_psychs', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_psychs_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_social_works', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_social_works_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });
    }
};
