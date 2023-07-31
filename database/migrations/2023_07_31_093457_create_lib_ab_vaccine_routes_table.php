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
        Schema::create('lib_ab_vaccine_routes', function (Blueprint $table) {
            $table->string('code', 2)->primary();
            $table->string('desc');
            $table->unsignedInteger('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_ab_vaccine_routes');
    }
};
