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
        Schema::create('medicine_lists', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('brand_name', 255)->nullable();
            $table->string('medicine_code')->index()->nullable();
            $table->string('konsulta_medicine_code')->index()->nullable();
            $table->string('added_medicine', 255)->nullable();
            $table->unsignedInteger('dosage_quantity');
            $table->char('dosage_uom', 10);
            $table->char('dose_regimen', 10);
            $table->char('medicine_purpose', 10);
            $table->string('purpose_other')->nullable();
            $table->unsignedInteger('duration_intake');
            $table->char('duration_frequency', 10);
            $table->unsignedInteger('quantity');
            $table->char('quantity_preparation', 10);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('medicine_code')->references('hprodid')->on('lib_medicines');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('konsulta_medicine_code')->references('code')->on('lib_konsulta_medicines');
            $table->foreign('dosage_uom')->references('code')->on('lib_medicine_unit_of_measurements');
            $table->foreign('dose_regimen')->references('code')->on('lib_medicine_dose_regimens');
            $table->foreign('medicine_purpose')->references('code')->on('lib_medicine_purposes');
            $table->foreign('duration_frequency')->references('code')->on('lib_medicine_duration_frequencies');
            $table->foreign('quantity_preparation')->references('code')->on('lib_medicine_preparations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_lists');
    }
};
