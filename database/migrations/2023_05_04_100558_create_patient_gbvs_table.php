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
        Schema::create('patient_gbv', function (Blueprint $table) {
            $table->id();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('case_number', 30)->index()->nullable();
            $table->date('case_date')->index();
            $table->date('outcome_date')->index();
            $table->unsignedBigInteger('outcome_reason_id')->index()->nullable();
            $table->unsignedBigInteger('outcome_result_id')->index()->nullable();
            $table->unsignedBigInteger('outcome_verdict_id')->index()->nullable();
            $table->unsignedBigInteger('primary_complaint_id')->index()->nullable();
            $table->string('primary_complaint_specific')->nullable();
            $table->string('primary_complaint_specific')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('appointment_code')->references('code')->on('lib_appointments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv');
    }
};
