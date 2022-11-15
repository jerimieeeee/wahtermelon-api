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
        Schema::create('patient_vitals', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->dateTime('vitals_date')->index();
            $table->unsignedInteger('patient_age_years')->index()->nullable();
            $table->unsignedInteger('patient_age_months')->index()->nullable();
            $table->decimal('patient_temp',10,1)->nullable()->index();
            $table->decimal('patient_height',10,2)->nullable()->index();
            $table->decimal('patient_weight',10,2)->nullable()->index();
            $table->unsignedInteger('bp_systolic')->nullable()->index();
            $table->unsignedInteger('bp_diastolic')->nullable()->index();
            $table->decimal('patient_heart_rate',10,2)->nullable()->index();
            $table->decimal('patient_respiratory_rate',10,2)->nullable()->index();
            $table->decimal('patient_pulse_rate',10,2)->nullable()->index();
            $table->decimal('patient_waist',10,2)->nullable()->index();
            $table->decimal('patient_hip',10,2)->nullable()->index();
            $table->decimal('patient_limbs',10,2)->nullable()->index();
            $table->decimal('patient_muac',10,2)->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_vitals');
    }
};
