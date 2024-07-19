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
            $table->date('death_date');
            $table->integer('age_years');
            $table->integer('age_months');
            $table->integer('age_days');
            $table->foreignId('death_type')->on('lib_mortality_death_type');
            $table->foreignId('death_place')->on('lib_mortality_death_place');
            $table->string('barangay_code')->index();
            $table->string('immediate_cause', 50)->nullable()->constrained('lib_icd10s');
            $table->string('antecedent_cause', 50)->nullable()->constrained('lib_icd10s');
            $table->string('underlying_cause', 50)->nullable()->constrained('lib_icd10s');
            $table->text('death_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('barangay_code')->references('code')->on('barangays');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_death_record');
    }
};
