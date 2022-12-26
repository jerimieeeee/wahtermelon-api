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
        Schema::create('patient_social_histories', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('smoking')->nullable();
            $table->double('pack_per_year')->nullable();
            $table->string('alcohol')->nullable();
            $table->double('bottles_per_day')->nullable();
            $table->string('illicit_drugs')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('smoking')->references('id')->on('lib_patient_social_history_answers');
            $table->foreign('alcohol')->references('id')->on('lib_patient_social_history_answers');
            $table->foreign('illicit_drugs')->references('id')->on('lib_patient_social_history_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_social_histories');
    }
};
