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
            $table->boolean('child_caretaker_present_flag')->after('child_behavior_id')->nullable();
            $table->foreignId('dev_screening_id')->after('child_behavior_remarks')->nullable()->constrained('lib_gbv_developmental_screenings');

            $table->boolean('source_from_victim_flag')->after('deferred')->nullable();
            $table->boolean('source_from_historian_flag')->after('source_from_victim_flag')->nullable();
            $table->boolean('source_from_sworn_statement_flag')->after('source_from_historian_flag')->nullable();
            $table->foreignId('mental_age_id')->after('source_from_sworn_statement_flag')->nullable()->constrained('lib_gbv_mental_ages');

            $table->foreignId('disclosed_relation_id')->after('disclosed_type')->nullable()->constrained('lib_gbv_disclosed_types');

            $table->string('witnessed_name')->after('witnessed_flag')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('child_caretaker_present_flag');
            $table->dropForeign('patient_gbv_interviews_dev_screening_id_foreign');
            $table->dropColumn('dev_screening_id');

            $table->dropColumn('source_from_victim_flag');
            $table->dropColumn('source_from_historian_flag');
            $table->dropColumn('source_from_sworn_statement_flag');
            $table->dropForeign('patient_gbv_interviews_mental_age_id_foreign');
            $table->dropColumn('mental_age_id');

            $table->dropForeign('patient_gbv_interviews_disclosed_relation_id_foreign');
            $table->dropColumn('disclosed_relation_id');

            $table->dropColumn('witnessed_name');
        });
    }
};
