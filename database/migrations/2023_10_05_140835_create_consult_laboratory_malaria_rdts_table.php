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
        Schema::create('consult_laboratory_malaria_rdts', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();
            $table->string('referral_facility')->nullable()->index();

            $table->char('parasite_type', 10);
            $table->char('rdt_number', 50)->nullable();

            $table->string('remarks')->nullable();
            $table->char('lab_status_code', 10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
            $table->foreign('parasite_type')->references('code')->on('lib_laboratory_malaria_rdt_parasite_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_laboratory_malaria_rdts');
    }
};
