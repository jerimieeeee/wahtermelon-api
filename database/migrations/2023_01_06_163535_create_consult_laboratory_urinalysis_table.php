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
        Schema::create('consult_laboratory_urinalysis', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();

            $table->string('gravity', 50)->nullable();
            $table->string('appearance', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('glucose', 50)->nullable();
            $table->string('proteins', 50)->nullable();
            $table->string('ketones', 50)->nullable();
            $table->string('ph', 50)->nullable();
            $table->string('rb_cells', 50)->nullable();
            $table->string('wb_cells', 50)->nullable();
            $table->string('bacteria', 50)->nullable();
            $table->string('crystals', 50)->nullable();
            $table->string('bladder_cells', 50)->nullable();
            $table->string('squamous_cells', 50)->nullable();
            $table->string('tubular_cells', 50)->nullable();
            $table->string('broad_cast', 50)->nullable();
            $table->string('epithelial_cast', 50)->nullable();
            $table->string('granular_cast', 50)->nullable();
            $table->string('hyaline_cast', 50)->nullable();
            $table->string('rbc_cast', 50)->nullable();
            $table->string('waxy_cast', 50)->nullable();
            $table->string('wc_cast', 50)->nullable();
            $table->string('albumin', 50)->nullable();
            $table->string('pus_cells', 50)->nullable();

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
        Schema::dropIfExists('consult_laboratory_urinalysis');
    }
};
