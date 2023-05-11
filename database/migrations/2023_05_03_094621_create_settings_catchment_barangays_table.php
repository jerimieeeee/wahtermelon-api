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
        Schema::create('settings_catchment_barangays', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->year('year')->index();
            $table->string('barangay_code')->index()->nullable();
            $table->integer('population')->index()->nullable();
            $table->integer('population_opt')->index()->nullable();
            $table->integer('population_wra')->index()->nullable();
            $table->integer('household')->index()->nullable();
            $table->boolean('zod')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_catchment_barangays');
    }
};
