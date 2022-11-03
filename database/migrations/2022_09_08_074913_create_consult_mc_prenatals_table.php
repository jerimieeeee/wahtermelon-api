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
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_mc_id')->index()->constrained('patient_mc');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('prenatal_date')->index();
            $table->unsignedInteger('aog_weeks');
            $table->unsignedInteger('aog_days');
            $table->unsignedInteger('trimester');
            $table->unsignedInteger('visit_sequence');
            $table->decimal('patient_height',3,2)->nullable();
            $table->decimal('patient_weight',3,2)->nullable();
            $table->unsignedInteger('bp_systolic')->nullable();
            $table->unsignedInteger('bp_diastolic')->nullable();
            $table->unsignedInteger('fundic_height')->nullable();
            $table->char('presentation_code',10)->index();
            $table->unsignedInteger('fhr')->nullable();
            $table->char('location_code',5)->index();
            $table->boolean('private')->default('0');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('presentation_code')->references('code')->on('lib_mc_presentations');
            $table->foreign('location_code')->references('code')->on('lib_mc_locations');
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
