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
        Schema::create('consult_laboratory_fecalysis', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();

            $table->char('color_code', 10)->index();
            $table->char('consistency_code', 10)->index();
            $table->string('rbc')->nullable();
            $table->string('wbc')->nullable();
            $table->string('ova')->nullable();
            $table->string('parasite')->nullable();
            $table->char('blood_code', 10)->index();
            $table->string('pus_cells')->nullable();

            $table->string('remarks')->nullable();
            $table->char('lab_status_code',10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
            $table->foreign('color_code')->references('code')->on('lib_laboratory_stool_colors');
            $table->foreign('consistency_code')->references('code')->on('lib_laboratory_stool_consistencies');
            $table->foreign('blood_code')->references('code')->on('lib_laboratory_blood_in_stools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_laboratory_fecalysis');
    }
};
