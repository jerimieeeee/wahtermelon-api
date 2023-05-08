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
        Schema::create('patient_gbvs', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('case_number', 30)->index()->nullable();
            $table->date('case_date')->index()->nullable();
            $table->date('outcome_date')->index()->nullable();
            $table->foreignId('outcome_reason_id')->index()->nullable()->constrained('lib_gbv_outcome_reasons');
            $table->foreignId('outcome_result_id')->index()->nullable()->constrained('lib_gbv_outcome_results');
            $table->foreignId('outcome_verdict_id')->index()->nullable()->constrained('lib_gbv_outcome_verdicts');
            $table->foreignId('primary_complaint_id')->index()->nullable()->constrained('lib_gbv_primary_complaints');
            $table->foreignId('service_id')->index()->nullable()->constrained('lib_gbv_services');
            $table->text('primary_complaint_remarks')->nullable();
            $table->text('service_remarks')->nullable();
            $table->text('neglect_remarks')->nullable();
            $table->text('behavioral_remarks')->nullable();
            $table->foreignId('economic_status_id')->index()->nullable()->constrained('lib_gbv_economic_statuses');
            $table->string('barangay_code')->index()->nullable();
            $table->string('address')->index()->nullable();
            $table->string('direction_to_address')->index()->nullable();
            $table->string('guardian_name')->index()->nullable();
            $table->string('guardian_address')->index()->nullable();
            $table->foreignId('relation_to_child_id')->index()->nullable()->constrained('lib_gbv_child_relations');
            $table->string('guardian_contact_info', 13)->nullable();
            $table->unsignedInteger('number_of_children')->nullable();
            $table->unsignedInteger('number_of_individual_members')->nullable();
            $table->unsignedInteger('number_of_family')->nullable();
            $table->boolean('same_bed_adult_male_flag')->index()->nullable();
            $table->boolean('same_bed_adult_female_flag')->index()->nullable();
            $table->boolean('same_bed_child_male_flag')->index()->nullable();
            $table->boolean('same_bed_child_female_flag')->index()->nullable();
            $table->boolean('same_room_adult_male_flag')->index()->nullable();
            $table->boolean('same_room_adult_female_flag')->index()->nullable();
            $table->boolean('same_room_child_male_flag')->index()->nullable();
            $table->foreignId('sleeping_arrangement_id')->index()->nullable()->constrained('lib_gbv_sleeping_arrangements');
            $table->foreignId('abuse_living_arrangement_id')->index()->nullable()->constrained('lib_gbv_living_arrangements');
            $table->foreignId('present_living_arrangement_id')->index()->nullable()->constrained('lib_gbv_living_arrangements');
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
        Schema::dropIfExists('patient_gbvs');
    }
};
