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
        Schema::create('patient_pregnancy_histories', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            // $table->uuid('post_partum_id')->index()->constrained();
            $table->unsignedInteger('gravidity');
            $table->unsignedInteger('parity');
            $table->unsignedInteger('full_term');
            $table->unsignedInteger('preterm');
            $table->unsignedInteger('abortion');
            $table->unsignedInteger('livebirths');
            $table->char('delivery_type', 10)->constrained();
            $table->char('induced_hypertension', 10)->constrained();
            $table->char('with_family_planning', 10)->constrained();
            $table->char('pregnancy_history_applicable', 10)->constrained();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            // $table->foreign('post_partum_id')->references('id')->on('patient_mc_post_registrations');
            $table->foreign('delivery_type')->references('code')->on('lib_pregnancy_delivery_types');
            $table->foreign('induced_hypertension')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('with_family_planning')->references('id')->on('lib_ncd_answer_s2');
            $table->foreign('pregnancy_history_applicable')->references('id')->on('lib_ncd_answer_s2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_pregnancy_histories');
    }
};
