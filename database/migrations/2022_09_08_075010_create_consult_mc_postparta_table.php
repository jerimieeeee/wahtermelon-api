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
            $table->id();
            $table->foreignId('mc_id')->constrained();
            // $table->foreignId('consult_id')->constrained();
            $table->foreignUuid('patients_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->date('postpartum_date');
            $table->unsignedInteger('postpartum_week')->length(3);
            $table->unsignedInteger('visit_sequence')->length(3);
            $table->char('visit_type',10);
            $table->boolean('breastfeeding')->default('0');
            $table->boolean('family_planning')->default('0');
            $table->boolean('fever')->default('0');
            $table->boolean('vaginal_infection')->default('0');
            $table->boolean('vaginal_bleeding')->default('0');
            $table->boolean('pallor')->default('0');
            $table->boolean('cord_ok')->default('0');
            $table->unsignedInteger('patient_age')->length(3);
            $table->unsignedInteger('patient_height')->length(3);
            $table->unsignedInteger('bp_systolic')->length(3);
            $table->unsignedInteger('bp_diastolic')->length(3);
            $table->softDeletes();
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
        Schema::dropIfExists('consult_mc_postparta');
    }
};
