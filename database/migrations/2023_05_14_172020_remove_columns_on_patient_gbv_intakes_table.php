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
            $table->dropColumn('outcome_date');

            $table->dropForeign('patient_gbvs_outcome_reason_id_foreign');
            $table->dropColumn('outcome_reason_id');

            $table->dropForeign('patient_gbvs_outcome_result_id_foreign');
            $table->dropColumn('outcome_result_id');

            $table->dropForeign('patient_gbvs_outcome_verdict_id_foreign');
            $table->dropColumn('outcome_verdict_id');

            //add new column
            // $table->foreignUlid('patient_gbv_id')->after('facility_code')->index()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->date('outcome_date')->after('case_date')->index()->nullable();
            $table->foreignId('outcome_reason_id')->after('outcome_date')->index()->nullable()->constrained('lib_gbv_outcome_reasons');
            $table->foreignId('outcome_result_id')->after('outcome_reason_id')->index()->nullable()->constrained('lib_gbv_outcome_results');
            $table->foreignId('outcome_verdict_id')->after('outcome_result_id')->index()->nullable()->constrained('lib_gbv_outcome_verdicts');
        });
    }
};
