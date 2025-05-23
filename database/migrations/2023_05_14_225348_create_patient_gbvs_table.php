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
        Schema::create('patient_gbvs', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->date('outcome_date')->index()->nullable();
            $table->foreignId('outcome_reason_id')->index()->nullable()->constrained('lib_gbv_outcome_reasons');
            $table->foreignId('outcome_result_id')->index()->nullable()->constrained('lib_gbv_outcome_results');
            $table->foreignId('outcome_verdict_id')->index()->nullable()->constrained('lib_gbv_outcome_verdicts');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('patient_gbvs');
        Schema::enableForeignKeyConstraints();
    }
};
