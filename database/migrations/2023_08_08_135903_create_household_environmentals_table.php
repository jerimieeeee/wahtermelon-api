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
        Schema::create('household_environmentals', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('household_folder_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->date('registration_date');
            $table->year('effectivity_year')->index();
            $table->unsignedBigInteger('water_type_code')->constrained();
            $table->boolean('safety_managed_flag');
            $table->boolean('sanitation_managed_flag');
            $table->boolean('satisfaction_management_flag');
            $table->boolean('complete_sanitation_flag');
            $table->boolean('located_premises_flag');
            $table->boolean('availability_flag');
            $table->string('microbiological_result')->nullable()->constrained();
            $table->date('validation_date')->nullable();
            $table->string('arsenic_result')->nullable()->constrained();
            $table->date('arsenic_date')->nullable();
            $table->boolean('open_defecation_flag');
            $table->unsignedBigInteger('toilet_facility_code')->constrained();
            $table->boolean('toilet_shared_flag');
            $table->unsignedBigInteger('sewage_code')->constrained();
            $table->unsignedBigInteger('waste_management_code')->constrained();
            $table->text('remarks')->nullable();
            $table->boolean('end_sanitation_flag');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('water_type_code')->references('code')->on('lib_environmental_water_types');
            $table->foreign('microbiological_result')->references('code')->on('lib_environmental_results');
            $table->foreign('arsenic_result')->references('code')->on('lib_environmental_results');
            $table->foreign('toilet_facility_code')->references('code')->on('lib_environmental_toilet_facilities');
            $table->foreign('sewage_code')->references('code')->on('lib_environmental_sewages');
            $table->foreign('waste_management_code')->references('code')->on('lib_environmental_waste_management');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_environmentals');
    }
};
