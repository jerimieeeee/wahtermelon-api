<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consult_laboratory_skin_slit_smears', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();
            $table->string('referral_facility')->nullable()->index();

            $table->string('site_slit1', 150)->nullable();
            $table->string('site_slit2', 150)->nullable();
            $table->string('site_slit3', 150)->nullable();
            $table->string('site_slit4', 150)->nullable();
            $table->string('site_slit5', 150)->nullable();
            $table->string('site_slit6', 150)->nullable();

            $table->string('bac_index1', 150)->nullable();
            $table->string('bac_index2', 150)->nullable();
            $table->string('bac_index3', 150)->nullable();
            $table->string('bac_index4', 150)->nullable();
            $table->string('bac_index5', 150)->nullable();
            $table->string('bac_index6', 150)->nullable();

            $table->string('morp_index1', 150)->nullable();
            $table->string('morp_index2', 150)->nullable();
            $table->string('morp_index3', 150)->nullable();
            $table->string('morp_index4', 150)->nullable();
            $table->string('morp_index5', 150)->nullable();
            $table->string('morp_index6', 150)->nullable();

            $table->string('comment1', 150)->nullable();
            $table->string('comment2', 150)->nullable();
            $table->string('comment3', 150)->nullable();
            $table->string('comment4', 150)->nullable();
            $table->string('comment5', 150)->nullable();
            $table->string('comment6', 150)->nullable();

            $table->string('avg_bac_index', 150)->nullable();
            $table->string('avg_morp_index', 150)->nullable();

            $table->string('final_comment')->nullable();

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
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_laboratory_skin_slit_smears');
    }
};
