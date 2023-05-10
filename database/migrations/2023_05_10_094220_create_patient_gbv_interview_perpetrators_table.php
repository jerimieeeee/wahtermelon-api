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
        Schema::create('patient_gbv_interview_perpetrators', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_id')->index()->constrained();
            $table->boolean('perpetrator_unknown_flag')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('perpetrator_name')->index()->nullable();
            $table->string('perpetrator_nickname')->index()->nullable();
            $table->unsignedInteger('perpetrator_age')->nullable();
            $table->boolean('known_to_child_flag')->nullable();
            $table->foreignId('relation_to_child_id')->index()->nullable()->constrained('lib_gbv_child_relations');
            $table->foreignId('location_id')->index()->nullable()->constrained('lib_gbv_perpetrator_locations');
            $table->string('perpetrator_address')->index()->nullable();
            $table->boolean('abuse_alcohol_flag')->nullable();
            $table->boolean('abuse_drugs_flag')->nullable();
            $table->text('abuse_drugs_remarks')->nullable();
            $table->boolean('abuse_others_flag')->nullable();
            $table->text('abuse_others_remarks')->nullable();
            $table->boolean('abused_as_child_flag')->nullable();
            $table->boolean('abused_as_spouse_flag')->nullable();
            $table->boolean('spouse_abuser_flag')->nullable();
            $table->boolean('family_violence_flag')->nullable();
            $table->boolean('unknown_abused_flag')->nullable();
            $table->boolean('criminal_conviction_similar_flag')->nullable();
            $table->boolean('criminal_conviction_other_flag')->nullable();
            $table->boolean('criminal_record_unknown_flag')->nullable();
            $table->boolean('criminal_barangay_flag')->nullable();
            $table->text('criminal_barangay_remarks')->nullable();
            $table->char('occupation_code', 10)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('occupation_code')->references('code')->on('lib_occupations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_interview_perpetrators');
    }
};
