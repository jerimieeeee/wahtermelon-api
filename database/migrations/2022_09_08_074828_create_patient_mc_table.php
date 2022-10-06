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
        Schema::create('patient_mc', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patients_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('pre_registration_date')->index();
            $table->date('post_registration_date')->index();
            $table->date('lmp_date')->index();
            $table->date('edc_date')->index();
            $table->date('trimester1_date');
            $table->date('trimester2_date');
            $table->date('trimester3_date');
            $table->date('postpartum_date')->index();
            $table->date('admission_date')->index();
            $table->date('discharge_date')->index();
            $table->date('delivery_date')->index();
            $table->char('delivery_location_code',10)->index();
            $table->string('barangay_code')->nullable()->index();
            $table->unsignedInteger('initial_gravidity');
            $table->unsignedInteger('initial_parity');
            $table->unsignedInteger('initial_full_term');
            $table->unsignedInteger('initial_preterm');
            $table->unsignedInteger('initial_abortion');
            $table->unsignedInteger('initial_livebirths');
            $table->unsignedInteger('gravidity');
            $table->unsignedInteger('parity');
            $table->unsignedInteger('full_term');
            $table->unsignedInteger('preterm');
            $table->unsignedInteger('abortion');
            $table->unsignedInteger('livebirths');
            $table->char('outcome_code',10)->index();
            $table->boolean('healthy_baby');
            $table->decimal('birth_weight',3,2);
            $table->char('attendant_code',5)->index();
            $table->boolean('breastfeeding');
            $table->date('breastfed_date')->index();
            $table->unsignedInteger('patient_age');
            $table->unsignedInteger('patient_height');
            $table->boolean('end_pregnancy')->default('0');
            $table->string('prenatal_remarks');
            $table->string('postpartum_remarks');
            $table->date('pregnancy_termination_date');
            $table->char('pregnancy_termination_code')->index();
            $table->string('pregnancy_termination_cause');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('delivery_location_code')->references('code')->on('lib_mc_delivery_locations');
            $table->foreign('barangay_code')->references('code')->on('barangays');
            $table->foreign('outcome_code')->references('code')->on('lib_mc_outcomes');
            $table->foreign('attendant_code')->references('code')->on('lib_mc_attendants');
            $table->foreign('pregnancy_termination_code')->references('code')->on('lib_mc_pregnancy_terminations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_mc');
    }
};
