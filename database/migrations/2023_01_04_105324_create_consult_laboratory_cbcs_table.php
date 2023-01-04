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
        Schema::create('consult_laboratory_cbcs', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date');
            $table->string('hemoglobin',50);
            $table->string('hematocrit',50);
            $table->string('rbc',50);
            $table->string('mcv',50);
            $table->string('mch',50);
            $table->string('mchc',50);
            $table->string('wbc',50);
            $table->string('neutrophils',50);
            $table->string('lymphocytes',50);
            $table->string('basophils',50);
            $table->string('monocytes',50);
            $table->string('eosinophils',50);
            $table->string('stab',50);
            $table->string('juvenile',50);
            $table->string('platelets',50);
            $table->string('reticulocytes',50);
            $table->string('bleeding_time',50);
            $table->string('clothing_time',50);
            $table->string('esr',50);
            $table->string('remarks');
            $table->char('lab_status_code',10);
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
        Schema::dropIfExists('consult_laboratory_cbcs');
    }
};
