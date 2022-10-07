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
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('pre_registration_date')->nullable()->index();
            $table->date('post_registration_date')->nullable()->index();
            $table->date('lmp_date')->nullable()->index();
            $table->date('edc_date')->nullable()->index();
            $table->date('trimester1_date')->nullable();
            $table->date('trimester2_date')->nullable();
            $table->date('trimester3_date')->nullable();
            $table->date('postpartum_date')->nullable()->index();
            $table->dateTime('admission_date')->nullable()->index();
            $table->dateTime('discharge_date')->nullable()->index();
            $table->dateTime('delivery_date')->nullable()->index();
            $table->char('delivery_location_code',10)->nullable()->index();
            $table->string('barangay_code')->nullable()->index();
            $table->unsignedInteger('initial_gravidity')->default(0);
            $table->unsignedInteger('initial_parity')->default(0);
            $table->unsignedInteger('initial_full_term')->default(0);
            $table->unsignedInteger('initial_preterm')->default(0);
            $table->unsignedInteger('initial_abortion')->default(0);
            $table->unsignedInteger('initial_livebirths')->default(0);
            $table->unsignedInteger('gravidity')->default(0);
            $table->unsignedInteger('parity')->default(0);
            $table->unsignedInteger('full_term')->default(0);
            $table->unsignedInteger('preterm')->default(0);
            $table->unsignedInteger('abortion')->default(0);
            $table->unsignedInteger('livebirths')->default(0);
            $table->char('outcome_code',10)->nullable()->index();
            $table->boolean('healthy_baby')->nullable();
            $table->decimal('birth_weight',3,2)->nullable();
            $table->char('attendant_code',5)->nullable()->index();
            $table->boolean('breastfeeding')->nullable();
            $table->date('breastfed_date')->nullable()->index();
            $table->unsignedInteger('patient_age');
            $table->unsignedInteger('patient_height');
            $table->boolean('end_pregnancy')->default('0');
            $table->string('prenatal_remarks')->nullable();
            $table->string('postpartum_remarks')->nullable();
            $table->date('pregnancy_termination_date')->nullable();
            $table->char('pregnancy_termination_code')->nullable()->index();
            $table->string('pregnancy_termination_cause')->nullable();
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
