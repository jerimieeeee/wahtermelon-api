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
        Schema::create('consult_laboratory_oral_glucose', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();

            $table->string('fasting_exam_mg', 50)->nullable();
            $table->string('fasting_exam_mmol', 50)->nullable();
            $table->string('ogtt_one_hour_mg', 50)->nullable();
            $table->string('ogtt_one_hour_mmol', 50)->nullable();
            $table->string('ogtt_two_hour_mg', 50)->nullable();
            $table->string('ogtt_two_hour_mmol', 50)->nullable();

            $table->string('remarks')->nullable();
            $table->char('lab_status_code', 10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_laboratory_oral_glucose');
    }
};
