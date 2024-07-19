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
        Schema::create('dental_medical_socials', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();

            $table->boolean('allergies_flag')->default(false);
            $table->boolean('hypertension_flag')->default(false);
            $table->boolean('diabetes_flag')->default(false);
            $table->boolean('blood_disorder_flag')->default(false);
            $table->boolean('heart_disease_flag')->default(false);
            $table->boolean('thyroid_flag')->default(false);
            $table->boolean('hepatitis_flag')->default(false);
            $table->boolean('malignancy_flag')->default(false);
            $table->boolean('blood_transfusion_flag')->default(false);
            $table->boolean('tattoo_flag')->default(false);
            $table->boolean('medical_others_flag')->default(false);
            $table->string('medical_remarks')->nullable();
            $table->boolean('sweet_flag')->default(false);
            $table->boolean('tabacco_flag')->default(false);
            $table->boolean('alcohol_flag')->default(false);
            $table->boolean('nut_flag')->default(false);
            $table->boolean('social_others_flag')->default(false);
            $table->string('social_remarks')->nullable();
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
        Schema::dropIfExists('dental_medical_socials');
    }
};
