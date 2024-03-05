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
        Schema::table('patient_ccdevs', function (Blueprint $table) {
            $table->dateTime('admission_date')->nullable()->change();
            $table->dateTime('discharge_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_ccdevs', function (Blueprint $table) {
            $table->dateTime('admission_date')->nullable(0)->change();
            $table->dateTime('discharge_date')->nullable(0)->change();
        });
    }
};
