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
        Schema::create('patient_services', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('facility_code')->index();
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('service_date')->nullable();
            $table->char('lib_service_id', 10)->index();
            $table->unsignedInteger('quantity')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('lib_service_id')->references('id')->on('lib_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_services');
    }
};
