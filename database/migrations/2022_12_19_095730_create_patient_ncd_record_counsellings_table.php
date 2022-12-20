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
        Schema::create('patient_ncd_record_counsellings', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignUuid('patient_ncd_record_id')->index()->constrained('patient_ncd_records');
            $table->uuid('consult_ncd_risk_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->unsignedBigInteger('counselling_code')->constrained();
            $table->timestamps();

            $table->foreign('consult_ncd_risk_id')->references('id')->on('consult_ncd_risk_assessment');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('counselling_code')->references('id')->on('lib_ncd_record_counsellings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_ncd_record_counsellings');
    }
};
