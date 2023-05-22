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
        Schema::create('patient_gbv_legal_cases', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_intake_id')->constrained('patient_gbv_intakes');

            $table->boolean('complaint_filed_flag')->nullable();
            $table->string('filed_by_name')->nullable();
            $table->foreignId('filed_by_relation_id')->nullable()->constrained('lib_gbv_child_relations');
            $table->foreignId('filed_location_id')->nullable()->constrained('lib_gbv_legal_filing_locations');
            $table->string('filed_location_remarks')->nullable();
            $table->boolean('case_initiated_flag')->nullable();
            $table->string('judge_name')->nullable();
            $table->string('court_name')->nullable();
            $table->string('fiscal_name')->nullable();
            $table->string('criminal_case_number')->nullable();
            $table->date('cpumd_testimony_date')->nullable();
            $table->foreignId('verdict_id')->nullable()->constrained('lib_gbv_outcome_verdicts');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_legal_cases');
    }
};
