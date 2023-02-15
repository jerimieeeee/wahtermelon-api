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
        Schema::create('patient_ncd_records', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignUuid('patient_ncd_id')->index()->constrained('patient_ncd');
            $table->uuid('consult_ncd_risk_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->date('consultation_date');
            $table->text('current_medications')->nullable();
            $table->unsignedBigInteger('palpitation_heart');
            $table->unsignedBigInteger('peripheral_pulses');
            $table->unsignedBigInteger('abdomen');
            $table->unsignedBigInteger('heart');
            $table->unsignedBigInteger('lungs');
            $table->unsignedBigInteger('sensation_feet');
            $table->text('other_findings')->nullable();
            $table->text('other_infos')->nullable();
            $table->timestamps();

            $table->foreign('consult_ncd_risk_id')->references('id')->on('consult_ncd_risk_assessment');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('palpitation_heart')->references('id')->on('lib_ncd_physical_exam_answers');
            $table->foreign('peripheral_pulses')->references('id')->on('lib_ncd_physical_exam_answers');
            $table->foreign('abdomen')->references('id')->on('lib_ncd_physical_exam_answers');
            $table->foreign('heart')->references('id')->on('lib_ncd_physical_exam_answers');
            $table->foreign('lungs')->references('id')->on('lib_ncd_physical_exam_answers');
            $table->foreign('sensation_feet')->references('id')->on('lib_ncd_physical_exam_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_ncd_records');
    }
};
