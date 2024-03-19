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
        Schema::create('consult_laboratory_hematologies', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();
            $table->string('hemoglobin', 50)->nullable();
            $table->string('hematocrit', 50)->nullable();
            $table->string('rbc', 50)->nullable();
            $table->string('mcv', 50)->nullable();
            $table->string('mch', 50)->nullable();
            $table->string('mchc', 50)->nullable();
            $table->string('wbc', 50)->nullable();
            $table->string('neutrophils', 50)->nullable();
            $table->string('lymphocytes', 50)->nullable();
            $table->string('basophils', 50)->nullable();
            $table->string('monocytes', 50)->nullable();
            $table->string('eosinophils', 50)->nullable();
            $table->string('stab', 50)->nullable();
            $table->string('juvenile', 50)->nullable();
            $table->string('platelets', 50)->nullable();
            $table->string('reticulocytes', 50)->nullable();
            $table->string('bleeding_time', 50)->nullable();
            $table->string('clothing_time', 50)->nullable();
            $table->string('esr', 50)->nullable();
            $table->char('blood_type_code', 3)->default('NA');
            $table->string('remarks')->nullable();
            $table->char('lab_status_code', 10)->index();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('blood_type_code')->references('code')->on('lib_blood_types');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_laboratory_hematologies');
    }
};
