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
        Schema::create('consult_mc_prenatals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mc_id')->constrained();
            $table->foreignUuid('patients_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->date('prenatal_date');
            $table->unsignedInteger('aog_weeks')->length(4);
            $table->unsignedInteger('aog_days')->length(3);
            $table->unsignedInteger('trimester')->length(2);
            $table->unsignedInteger('visit_sequence')->length(3);
            $table->decimal('patient_weight',3,2);
            $table->unsignedInteger('bp_systolic')->length(3);
            $table->unsignedInteger('bp_diastolic')->length(3);
            $table->unsignedInteger('fundic_height')->length(3);
            $table->char('fetal_presentation_id',10);
            $table->unsignedInteger('fhr')->length(3);
            $table->char('fhr_location_id',5);
            $table->boolean('private')->default('0');
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
        Schema::dropIfExists('consult_mc_prenatals');
    }
};
