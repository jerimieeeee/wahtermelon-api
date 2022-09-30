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
            $table->uuid('patient_mc_id');
            $table->foreignUuid('patient_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->date('prenatal_date');
            $table->unsignedInteger('aog_weeks');
            $table->unsignedInteger('aog_days');
            $table->unsignedInteger('trimester');
            $table->unsignedInteger('visit_sequence');
            $table->decimal('patient_weight',3,2);
            $table->unsignedInteger('bp_systolic');
            $table->unsignedInteger('bp_diastolic');
            $table->unsignedInteger('fundic_height');
            $table->char('presentation_code',10)->constrained();
            $table->unsignedInteger('fhr');
            $table->char('location_code',5)->constrained();
            $table->boolean('private')->default('0');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('patient_mc_id')->references('id')->on('patient_mc');
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
