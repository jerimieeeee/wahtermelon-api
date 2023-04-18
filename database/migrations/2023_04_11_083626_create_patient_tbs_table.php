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
        Schema::create('patient_tbs', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('tb_treatment_outcome_code', 4)->nullable();
            $table->foreignId('lib_tb_outcome_reason_id')->nullable()->constrained();
            $table->date('outcome_date')->nullable();
            $table->boolean('treatment_done')->default(0);
            $table->string('outcome_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('tb_treatment_outcome_code')->references('code')->on('lib_tb_treatment_outcomes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tbs');
    }
};
