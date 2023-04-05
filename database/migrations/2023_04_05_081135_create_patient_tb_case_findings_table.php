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
        Schema::create('patient_tb_case_findings', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('source_code',3);
            $table->string('reg_group_code',5);
            $table->string('previous_tb_treatment_code',2);
            $table->boolean('exposetb_flag')->default(0);
            $table->boolean('drtb_flag')->default(0);
            $table->boolean('risk_factor1')->default(0);
            $table->boolean('risk_factor2')->default(0);
            $table->boolean('risk_factor3')->default(0);
            $table->date('consult_date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('source_code')->references('code')->on('lib_tb_patient_sources');
            $table->foreign('reg_group_code')->references('code')->on('lib_tb_reg_groups');
            $table->foreign('previous_tb_treatment_code')->references('code')->on('lib_tb_previous_tb_treatments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tb_case_findings');
    }
};
