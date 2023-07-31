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
        Schema::create('lib_ab_exposure_types', function (Blueprint $table) {
            $table->string('code', 10)->primary();
            $table->char('category', 3);
            $table->string('desc');
            $table->string('icd10')->nullable();
            $table->unsignedInteger('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_ab_exposure_types');
    }
};
