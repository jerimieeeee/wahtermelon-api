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
        Schema::create('consult_ncd_risk_questionnaire', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('consult_ncd_risk_id')->index()->constrained();
            $table->foreignUuid('patient_ncd_id')->index()->constrained('patient_ncd');
            $table->unsignedBigInteger('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('question1');
            $table->string('question2');
            $table->string('question3');
            $table->string('question4');
            $table->string('question5');
            $table->string('question6');
            $table->string('question7');
            $table->string('question8');
            $table->string('angina_heart_attack');
            $table->string('stroke_tia');
            $table->timestamps();

            $table->foreign('consult_ncd_risk_id')->references('id')->on('consult_ncd_risk_assessment');
            $table->foreign('consult_id')->references('id')->on('consults');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('question1')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question2')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question3')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question4')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question5')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question6')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question7')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('question8')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('angina_heart_attack')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('stroke_tia')->references('id')->on('lib_ncd_answer_s2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_ncd_risk_questionnaire');
    }
};
