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
        Schema::create('mcs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patients_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->date('pre_registration_date');
            $table->date('post_registration_date');
            $table->date('lmp_date');
            $table->date('edc_date');
            $table->date('trimester1_date');
            $table->date('trimester2_date');
            $table->date('trimester3_date');
            $table->date('postpartum_date');
            $table->date('admission_date');
            $table->date('discharge_date');
            $table->date('delivery_date');
            $table->char('delivery_location',10);
            $table->foreignId('barangay_id')->nullable()->constrained();
            $table->unsignedInteger('initial_gravidity')->length(3);
            $table->unsignedInteger('initial_parity')->length(3);
            $table->unsignedInteger('initial_full_term')->length(3);
            $table->unsignedInteger('initial_preterm')->length(3);
            $table->unsignedInteger('initial_abortion')->length(3);
            $table->unsignedInteger('initial_livebirths')->length(3);
            $table->unsignedInteger('gravidity')->length(3);
            $table->unsignedInteger('parity')->length(3);
            $table->unsignedInteger('full_term')->length(3);
            $table->unsignedInteger('preterm')->length(3);
            $table->unsignedInteger('abortion')->length(3);
            $table->unsignedInteger('livebirths')->length(3);
            $table->char('outcome_id',10);
            $table->boolean('healthy_baby');
            $table->decimal('birth_weight',3,2);
            $table->char('attendant_id',5);
            $table->boolean('breastfeeding');
            $table->date('breastfed_date');
            $table->unsignedInteger('patient_age')->length(3);
            $table->unsignedInteger('patient_height')->length(3);
            $table->boolean('end_pregnancy',1)->default('0');
            $table->string('prenatal_remarks',255);
            $table->string('postpartum_remarks',255);
            $table->date('pregnancy_termination_date');
            $table->char('pregnancy_termination_code');
            $table->string('pregnancy_termination_cause',255);
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
        Schema::dropIfExists('mcs');
    }
};
