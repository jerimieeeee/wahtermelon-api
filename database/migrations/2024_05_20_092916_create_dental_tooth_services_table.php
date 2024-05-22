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
        Schema::create('dental_tooth_services', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('tooth_number', 3);
            $table->string('service_code', 3);
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('service_code')->references('code')->on('lib_dental_tooth_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_tooth_services');
    }
};
