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
        Schema::create('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_intake_id')->index()->constrained();
            $table->decimal('patient_temp', 10, 1)->nullable()->index();
            $table->decimal('patient_heart_rate', 10, 2)->nullable()->index();
            $table->decimal('patient_weight', 10, 2)->nullable()->index();
            $table->decimal('patient_height', 10, 2)->nullable()->index();
            $table->boolean('taking_medication_flag')->nullable()->index();
            $table->text('taking_medication_remarks')->nullable();
            $table->foreignId('gbv_general_survey_id')->index()->nullable()->constrained('lib_gbv_general_surveys')->nullable();
            $table->text('gbv_general_survey_remarks')->nullable();
            $table->string('menarche_flag')->nullable()->index();
            $table->text('menarche_remarks')->nullable();
            $table->date('lmp_date')->nullable()->index();
            $table->boolean('genital_discharge_uti_flag')->nullable()->index();
            $table->boolean('past_hospitalizations_flag')->nullable()->index();
            $table->text('past_hospital_remarks')->nullable();
            $table->boolean('scar_physical_abuse_flag')->nullable()->index();
            $table->boolean('pertinent_med_history_flag')->nullable()->index();
            $table->text('medical_history_remarks')->nullable();
            $table->text('summary_non_abuse_findings')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('menarche_flag')->references('code')->on('lib_answer_ynx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_medical_histories');
    }
};
