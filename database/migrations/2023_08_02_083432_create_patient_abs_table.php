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
        Schema::create('patient_abs', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->date('consult_date');
            $table->date('exposure_date');
            $table->foreignId('ab_treatment_outcome_id')->nullable()->on('lib_ab_outcomes');
            $table->date('date_outcome')->nullable();
            $table->foreignId('ab_death_place_id')->nullable()->on('lib_ab_death_places');
            $table->text('manifestations')->nullable();
            $table->date('date_onset')->nullable();
            $table->date('date_died')->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('patient_abs');
    }
};
