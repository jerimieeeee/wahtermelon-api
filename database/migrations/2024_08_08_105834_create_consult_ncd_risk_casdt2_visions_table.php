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
        Schema::create('consult_ncd_risk_casdt2_visions', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('casdt2_id')->index()->constrained('consult_ncd_risk_casdt2s');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->char('eye_complaint', 50)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('eye_complaint')->references('code')->on('lib_ncd_eye_complaints');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_ncd_risk_casdt2_visions');
    }
};
