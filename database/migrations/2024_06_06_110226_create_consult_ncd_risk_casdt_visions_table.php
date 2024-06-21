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
        Schema::create('consult_ncd_risk_casdt_visions', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('consult_ncd_risk_id')->index()->constrained('consult_ncd_risk_assessment');
            $table->foreignUuid('patient_ncd_id')->index()->constrained('patient_ncd');
            $table->foreignId('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->char('eye_complaint')->nullable();
            $table->char('eye_refer')->nullable();
            $table->char('unaided')->nullable();
            $table->char('pinhole')->nullable();
            $table->char('improved')->nullable();
            $table->char('aided')->nullable();
            $table->char('eye_refer_prof')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('eye_complaint')->references('code')->on('lib_ncd_eye_complaints');
            $table->foreign('eye_refer')->references('code')->on('lib_ncd_eye_refers');
            $table->foreign('unaided')->references('code')->on('lib_ncd_eye_vision_screenings');
            $table->foreign('pinhole')->references('code')->on('lib_ncd_eye_vision_screenings');
            $table->foreign('improved')->references('code')->on('lib_ncd_eye_vision_screenings');
            $table->foreign('aided')->references('code')->on('lib_ncd_eye_vision_screenings');
            $table->foreign('eye_refer_prof')->references('code')->on('lib_ncd_eye_refer_professionals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_ncd_risk_casdt_visions');
    }
};
