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
        Schema::create('consult_ncd_risk_screening_glucose', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->uuid('consult_ncd_risk_id')->index()->constrained();
            $table->foreignUuid('patient_ncd_id')->index()->constrained('patient_ncd');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->date('date_taken');
            $table->char('fbs');
            $table->char('rbs');
            $table->boolean('raised_blood_glucose');
            $table->timestamps();

            $table->foreign('consult_ncd_risk_id')->references('id')->on('consult_ncd_risk_assessment');
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
        Schema::dropIfExists('consult_ncd_risk_screening_glucose');
    }
};
