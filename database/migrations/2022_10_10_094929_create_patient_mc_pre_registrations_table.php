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
        Schema::create('patient_mc_pre_registrations', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->foreignUuid('patient_mc_id')->index()->constrained('patient_mc');
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('pre_registration_date')->index();
            $table->date('lmp_date')->index();
            $table->date('edc_date')->index();
            $table->date('trimester1_date');
            $table->date('trimester2_date');
            $table->date('trimester3_date');
            $table->date('postpartum_date')->index();
            $table->unsignedInteger('initial_gravidity')->default(0);
            $table->unsignedInteger('initial_parity')->default(0);
            $table->unsignedInteger('initial_full_term')->default(0);
            $table->unsignedInteger('initial_preterm')->default(0);
            $table->unsignedInteger('initial_abortion')->default(0);
            $table->unsignedInteger('initial_livebirths')->default(0);
            $table->text('prenatal_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //$table->foreign('patient_mc_id')->references('id')->on('patient_mc');
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
        Schema::dropIfExists('patient_mc_pre_registrations');
    }
};
