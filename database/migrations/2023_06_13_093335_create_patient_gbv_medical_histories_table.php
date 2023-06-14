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
            $table->decimal('patient_temp', 10, 1)->nullable();
            $table->decimal('patient_heart_rate', 10, 2)->nullable();
            $table->decimal('patient_weight', 10, 2)->nullable();
            $table->decimal('patient_height', 10, 2)->nullable();
            $table->boolean('taking_medication_flag')->nullable();
            $table->text('taking_medication_remarks')->nullable();
            $table->boolean('general_survey_normal')->nullable();
            $table->boolean('general_survey_abnormal')->nullable();
            $table->boolean('general_survey_stunting')->nullable();
            $table->boolean('general_survey_wasting')->nullable();
            $table->boolean('general_survey_dirty_unkempt')->nullable();
            $table->boolean('general_survey_stuporous')->nullable();
            $table->boolean('general_survey_pale')->nullable();
            $table->boolean('general_survey_non_ambulant')->nullable();
            $table->boolean('general_survey_drowsy')->nullable();
            $table->boolean('general_survey_respiratory')->nullable();
            $table->boolean('general_survey_others')->nullable();
            $table->text('gbv_general_survey_remarks')->nullable();
            $table->string('menarche_flag')->nullable();
            $table->text('menarche_remarks')->nullable();
            $table->date('lmp_date')->nullable();
            $table->boolean('genital_discharge_uti_flag')->nullable();
            $table->boolean('past_hospitalizations_flag')->nullable();
            $table->text('past_hospital_remarks')->nullable();
            $table->boolean('scar_physical_abuse_flag')->nullable();
            $table->boolean('pertinent_med_history_flag')->nullable();
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
