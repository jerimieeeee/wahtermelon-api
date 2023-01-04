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
        Schema::create('consult_laboratory_chest_xrays', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date');
            $table->char('findings_code', 10)->index()->nullable();
            $table->string('remarks_findings')->nullable();
            $table->char('observation_code', 10)->index()->nullable();
            $table->string('remarks_observation')->nullable();
            $table->string('remarks')->nullable();
            $table->char('lab_status_code',10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
            $table->foreign('findings_code')->references('code')->on('lib_laboratory_chestxray_findings');
            $table->foreign('observation_code')->references('code')->on('lib_laboratory_chestxray_observations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_laboratory_chest_xrays');
    }
};
