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
        Schema::create('eclaims_rth_documents', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->string('pClaimSeriesLhio', 18);
            $table->char('doc_type_code', 3);
            $table->string('doc_url');
            $table->char('required', 1);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('doc_type_code')->references('code')->on('lib_eclaims_doc_types');
            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclaims_rth_documents');
    }
};
