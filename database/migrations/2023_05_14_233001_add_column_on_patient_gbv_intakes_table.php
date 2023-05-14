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
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->foreignUuid('patient_id')->after('id')->index()->constrained();
            $table->foreignUuid('user_id')->after('patient_id')->index()->constrained();
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreignUlid('patient_gbv_id')->after('facility_code')->index()->constrained();

            $table->foreign('present_living_arrangement_id')->references('id')->on('lib_gbv_living_arrangements');
            $table->foreign('sleeping_arrangement_id')->references('id')->on('lib_gbv_sleeping_arrangements');
            $table->foreign('abuse_living_arrangement_id')->references('id')->on('lib_gbv_living_arrangements');
            $table->foreign('relation_to_child_id')->references('id')->on('lib_gbv_child_relations');
            $table->foreign('economic_status_id')->references('id')->on('lib_gbv_economic_statuses');
            $table->foreign('primary_complaint_id')->references('id')->on('lib_gbv_primary_complaints');
            $table->foreign('service_id')->references('id')->on('lib_gbv_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_intakes_patient_id_foreign');
            $table->dropColumn('patient_id');

            $table->dropForeign('patient_gbv_intakes_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('patient_gbv_intakes_facility_code_foreign');
            $table->dropForeign('patient_gbv_intakes_patient_gbv_id_foreign');

            $table->dropForeign('patient_gbv_intakes_abuse_living_arrangement_id_foreign');
            $table->dropForeign('patient_gbv_intakes_economic_status_id_foreign');
            $table->dropForeign('patient_gbv_intakes_present_living_arrangement_id_foreign');
            $table->dropForeign('patient_gbv_intakes_primary_complaint_id_foreign');
            $table->dropForeign('patient_gbv_intakes_relation_to_child_id_foreign');
            $table->dropForeign('patient_gbv_intakes_service_id_foreign');
            $table->dropForeign('patient_gbv_intakes_sleeping_arrangement_id_foreign');
        });
    }
};
