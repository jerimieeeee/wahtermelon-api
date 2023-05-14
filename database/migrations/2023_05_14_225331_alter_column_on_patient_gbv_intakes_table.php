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
            $table->dropForeign('patient_gbvs_patient_id_foreign');
            $table->dropColumn('patient_id');

            $table->dropForeign('patient_gbvs_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('patient_gbvs_facility_code_foreign');

            $table->dropForeign('patient_gbvs_abuse_living_arrangement_id_foreign');
            $table->dropForeign('patient_gbvs_economic_status_id_foreign');
            $table->dropForeign('patient_gbvs_present_living_arrangement_id_foreign');
            $table->dropForeign('patient_gbvs_primary_complaint_id_foreign');
            $table->dropForeign('patient_gbvs_relation_to_child_id_foreign');
            $table->dropForeign('patient_gbvs_service_id_foreign');
            $table->dropForeign('patient_gbvs_sleeping_arrangement_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }
};
