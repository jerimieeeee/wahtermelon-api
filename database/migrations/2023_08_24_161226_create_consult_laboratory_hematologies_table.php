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
            $table->string('referral_facility')->index();
            $table->date('laboratory_date')->index();

            $table->string('hemoglobin', 50);
            $table->string('hematocrit', 50);
            $table->string('rbc', 50);
            $table->string('mcv', 50);
            $table->string('mchc', 50);
            $table->string('wbc', 50);
            $table->string('neutrophils', 50);

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('referral_facility')->references('code')->on('facilities');
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
