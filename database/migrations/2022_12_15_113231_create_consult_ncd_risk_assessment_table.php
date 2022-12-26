<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_ncd_risk_assessment', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->foreignUuid('patient_ncd_id')->index()->constrained('patient_ncd');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->unsignedBigInteger('consult_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->unsignedBigInteger('location');
            $table->unsignedBigInteger('client_type');
            $table->date('assessment_date');
            $table->string('family_hx_hypertension');
            $table->string('family_hx_stroke');
            $table->string('family_hx_heart_attack');
            $table->string('family_hx_diabetes');
            $table->string('family_hx_asthma');
            $table->string('family_hx_cancer');
            $table->string('family_hx_kidney_disease');
            $table->unsignedBigInteger('smoking');
            $table->unsignedBigInteger('alcohol_intake');
            $table->string('excessive_alcohol_intake');
            $table->string('high_fat');
            $table->string('intake_fruits');
            $table->string('physical_activity');
            $table->string('intake_vegetables');
            $table->string('presence_diabetes');
            $table->string('diabetes_medications');
            $table->string('polyphagia');
            $table->string('polydipsia');
            $table->string('polyuria');
            $table->boolean('obesity');
            $table->boolean('central_adiposity');
            $table->decimal('bmi', 10, 4);
            $table->unsignedInteger('waist_line');
            $table->boolean('raised_bp');
            $table->unsignedInteger('avg_systolic');
            $table->unsignedInteger('avg_diastolic');
            $table->unsignedInteger('systolic_1st');
            $table->unsignedInteger('diastolic_1st');
            $table->unsignedInteger('systolic_2nd');
            $table->unsignedInteger('diastolic_2nd');
            $table->enum('gender', ['M', 'F', 'I']);
            $table->unsignedInteger('age');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('consult_id')->references('id')->on('consults');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('location')->references('id')->on('lib_ncd_locations');
            $table->foreign('client_type')->references('id')->on('lib_ncd_client_types');
            $table->foreign('family_hx_hypertension')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_stroke')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_heart_attack')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_diabetes')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_asthma')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_cancer')->references('id')->on('lib_ncd_answers');
            $table->foreign('family_hx_kidney_disease')->references('id')->on('lib_ncd_answers');

            $table->foreign('smoking')->references('id')->on('lib_ncd_smoking_answers');
            $table->foreign('alcohol_intake')->references('id')->on('lib_ncd_alcohol_intake_answers');
            $table->foreign('excessive_alcohol_intake')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('high_fat')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('intake_fruits')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('physical_activity')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('intake_vegetables')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('presence_diabetes')->references('id')->on('lib_ncd_answers');
            $table->foreign('diabetes_medications')->references('id')->on('lib_ncd_answers');
            $table->foreign('polyphagia')->references('id')->on('lib_ncd_answers');
            $table->foreign('polydipsia')->references('id')->on('lib_ncd_answers');
            $table->foreign('polyuria')->references('id')->on('lib_ncd_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_ncd_risk_assessment');
    }
};
