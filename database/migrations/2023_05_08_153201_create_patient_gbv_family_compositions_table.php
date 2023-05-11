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
        Schema::create('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_id')->index()->constrained();
            $table->string('name')->nullable();
            $table->foreignId('child_relation_id')->index()->nullable()->constrained('lib_gbv_child_relations');
            $table->boolean('living_with_child_flag')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->char('civil_status_code', 10)->nullable();
            $table->boolean('employed_flag')->nullable();
            $table->char('occupation_code', 10)->nullable();
            $table->unsignedBigInteger('education_code')->nullable();
            $table->unsignedInteger('weekly_income')->nullable();
            $table->string('school')->nullable();
            $table->string('company')->nullable();
            $table->string('contact_information', 13)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('civil_status_code')->references('code')->on('lib_civil_statuses');
            $table->foreign('occupation_code')->references('code')->on('lib_occupations');
            $table->foreign('education_code')->references('code')->on('lib_education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_family_compositions');
    }
};
