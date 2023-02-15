<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_prescriptions', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('prescribed_by')->index()->nullable()->constrained('users');
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->date('prescription_date')->index();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_prescriptions');
    }
};
