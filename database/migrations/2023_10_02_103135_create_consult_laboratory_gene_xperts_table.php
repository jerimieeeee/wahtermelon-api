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
        Schema::create('consult_laboratory_gene_xperts', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignId('consult_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignUuid('request_id')->index()->constrained('consult_laboratories');
            $table->date('laboratory_date')->index();
            $table->string('referral_facility')->nullable()->index();

            $table->date('collection_date');
            $table->date('release_date');
            $table->char('mtb', 10);
            $table->char('rif', 10);
            $table->char('specimen_code', 20);

            $table->string('remarks')->nullable();
            $table->char('lab_status_code', 10)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('lab_status_code')->references('code')->on('lib_laboratory_statuses');
            $table->foreign('mtb')->references('code')->on('lib_laboratory_mtb_results');
            $table->foreign('rif')->references('code')->on('lib_laboratory_rif_results');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_laboratory_gene_xperts');
    }
};
