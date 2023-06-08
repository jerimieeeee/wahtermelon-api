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
        Schema::create('patient_gbv_pdf_uploads', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('patient_gbv_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->string('file_title');
            $table->string('file_desc');
            $table->string('file_url');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_pdf_uploads');
    }
};
