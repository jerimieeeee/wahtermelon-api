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
        Schema::create('settings_barangay_bhs', function (Blueprint $table) {
            $table->foreignUlid('settings_bhs_id')->index()->constrained();
            $table->foreignUlid('settings_catchment_barangay_id')->index()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_barangay_bhs');
    }
};
