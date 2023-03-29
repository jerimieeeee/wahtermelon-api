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
        Schema::create('patient_mc_post_registrations', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->foreignUuid('patient_mc_id')->index()->constrained('patient_mc');
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('post_registration_date')->index();
            $table->dateTime('admission_date')->index();
            $table->dateTime('discharge_date')->index();
            $table->dateTime('delivery_date')->index();
            $table->char('delivery_location_code', 10)->index();
            $table->string('barangay_code')->index();
            $table->unsignedInteger('gravidity')->default(0);
            $table->unsignedInteger('parity')->default(0);
            $table->unsignedInteger('full_term')->default(0);
            $table->unsignedInteger('preterm')->default(0);
            $table->unsignedInteger('abortion')->default(0);
            $table->unsignedInteger('livebirths')->default(0);
            $table->char('outcome_code', 10)->index();
            $table->boolean('healthy_baby');
            $table->decimal('birth_weight', 5, 2);
            $table->char('attendant_code', 5)->index();
            $table->boolean('breastfeeding')->default(0);
            $table->date('breastfed_date')->nullable()->index();
            $table->boolean('end_pregnancy')->default('0');
            $table->text('postpartum_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //$table->foreign('patient_mc_id')->references('id')->on('patient_mc');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('delivery_location_code')->references('code')->on('lib_mc_delivery_locations');
            $table->foreign('barangay_code')->references('code')->on('barangays');
            $table->foreign('outcome_code')->references('code')->on('lib_mc_outcomes');
            $table->foreign('attendant_code')->references('code')->on('lib_mc_attendants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_mc_post_registrations');
    }
};
