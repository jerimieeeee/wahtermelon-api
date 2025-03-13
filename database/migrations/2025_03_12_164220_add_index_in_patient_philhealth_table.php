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
        Schema::table('patient_philhealth', function (Blueprint $table) {
            $table->index('transmittal_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_philhealth', function (Blueprint $table) {
            $table->dropIndex(['transmittal_number']);
        });
    }
};
