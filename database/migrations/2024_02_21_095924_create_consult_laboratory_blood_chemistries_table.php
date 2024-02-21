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
        Schema::create('consult_laboratory_blood_chemistries', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();
            $table->string('referral_facility')->nullable()->index();

            //Electrolytes
            $table->string('bicarbonate', 150)->nullable();
            $table->string('calcium', 150)->nullable();
            $table->string('chloride', 150)->nullable();
            $table->string('magnesium', 150)->nullable();
            $table->string('phosphorus', 150)->nullable();
            $table->string('potassium', 150)->nullable();
            $table->string('sodium', 150)->nullable();

            //Enzymes
            $table->string('alkaline_phosphatase', 150)->nullable();
            $table->string('amylase', 150)->nullable();
            $table->string('creatine_kinase', 150)->nullable();
            $table->string('lipase', 150)->nullable();
            $table->string('alt', 150)->nullable();
            $table->string('ast', 150)->nullable();

            //Others
            $table->string('albumin', 150)->nullable();
            $table->string('total_bilirubin', 150)->nullable();
            $table->string('direct_bilirubin', 150)->nullable();
            $table->string('cholesterol', 150)->nullable();
            $table->string('creatinine', 150)->nullable();
            $table->string('globulin', 150)->nullable();
            $table->string('glucose', 150)->nullable();
            $table->string('protein', 150)->nullable();
            $table->string('triglycerides', 150)->nullable();
            $table->string('urea', 150)->nullable();
            $table->string('uric_acid', 150)->nullable();
            $table->string('fbs', 150)->nullable();
            $table->string('rbs', 150)->nullable();

            $table->string('remarks')->nullable();
            $table->char('lab_status_code', 10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_laboratory_blood_chemistries');
    }
};
