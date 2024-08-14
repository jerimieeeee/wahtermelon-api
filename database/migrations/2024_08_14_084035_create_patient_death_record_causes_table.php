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
        Schema::create('patient_death_record_causes', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('death_record_id')->index()->constrained('patient_death_records');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->string('icd10_code', 50)->nullable();
            $table->string('cause_code', 10)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('icd10_code')->references('icd10_code')->on('lib_icd10s');
            $table->foreign('cause_code')->references('code')->on('lib_mortality_causes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_death_record_causes');
    }
};
