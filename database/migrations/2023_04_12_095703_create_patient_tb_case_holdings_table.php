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
        Schema::create('patient_tb_case_holdings', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('patient_tb_id')->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('case_number', 50);
            $table->string('enroll_as_code', 4);
            $table->string('treatment_regimen_code', 5);
            $table->date('registration_date');
            $table->date('treatment_start');
            $table->date('continuation_start');
            $table->date('treatment_end');
            $table->string('bacteriological_status_code',2)->nullable();
            $table->string('anatomical_site_code', 2)->nullable();
            $table->foreignId('eptb_site_id')->nullable()->constrained('lib_tb_eptb_sites', 'id');
            $table->string('specific_site')->nullable();
            $table->boolean('drug_resistant_flag')->default(0);
            $table->char('ipt_type_code', 1)->nullable();
            $table->boolean('transfer_flag')->default(0);
            $table->date('pict_date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('enroll_as_code')->references('code')->on('lib_tb_enroll_as');
            $table->foreign('treatment_regimen_code')->references('code')->on('lib_tb_treatment_regimens');
            $table->foreign('bacteriological_status_code')->references('code')->on('lib_tb_bacteriological_statuses');
            $table->foreign('anatomical_site_code')->references('code')->on('lib_tb_anatomical_sites');
            $table->foreign('ipt_type_code')->references('code')->on('lib_tb_ipt_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tb_case_holdings');
    }
};
