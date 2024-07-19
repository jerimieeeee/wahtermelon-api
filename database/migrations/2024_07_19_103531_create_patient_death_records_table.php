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
        Schema::create('patient_death_records', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->dateTime('date_of_death');
            $table->integer('age_years');
            $table->integer('age_months');
            $table->integer('age_days');
            $table->string('death_type')->constrained();;
            $table->string('death_place')->constrained();;
            $table->string('barangay_code')->index();
            $table->string('immediate_cause', 50)->constrained()->nullable();
            $table->string('antecedent_cause', 50)->constrained()->nullable();
            $table->string('underlying_cause', 50)->constrained()->nullable();
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
            $table->foreign('death_type')->references('code')->on('lib_mortality_death_type');
            $table->foreign('death_place')->references('code')->on('lib_mortality_death_place');
            $table->foreign('immediate_cause')->references('icd10_code')->on('lib_icd10s');
            $table->foreign('antecedent_cause')->references('icd10_code')->on('lib_icd10s');
            $table->foreign('underlying_cause')->references('icd10_code')->on('lib_icd10s');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_death_records');
    }
};
