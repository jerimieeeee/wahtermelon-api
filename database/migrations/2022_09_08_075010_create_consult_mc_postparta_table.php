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
        Schema::create('consult_mc_postparta', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_mc_id')->index()->constrained('patient_mc');
            $table->foreignUuid('patient_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->date('postpartum_date')->index();
            $table->unsignedInteger('postpartum_week');
            $table->unsignedInteger('visit_sequence');
            $table->char('visit_type', 10);
            $table->boolean('breastfeeding')->default('0');
            $table->boolean('family_planning')->default('0');
            $table->boolean('fever')->default('0');
            $table->boolean('vaginal_infection')->default('0');
            $table->boolean('vaginal_bleeding')->default('0');
            $table->boolean('pallor')->default('0');
            $table->boolean('cord_ok')->default('0');
            $table->unsignedInteger('patient_height');
            $table->unsignedInteger('patient_weight');
            $table->unsignedInteger('bp_systolic');
            $table->unsignedInteger('bp_diastolic');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_mc_postparta');
    }
};
