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
        Schema::table('consult_mc_postparta', function (Blueprint $table) {
            $table->decimal('patient_height', 5, 2)->nullable()->change();
            $table->decimal('patient_weight', 5, 2)->nullable()->change();
            $table->unsignedInteger('bp_systolic')->nullable()->change();
            $table->unsignedInteger('bp_diastolic')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_mc_postparta', function (Blueprint $table) {
            $table->unsignedInteger('patient_height')->nullable(0)->change();
            $table->unsignedInteger('patient_weight')->nullable(0)->change();
            $table->unsignedInteger('bp_systolic')->nullable(0)->change();
            $table->unsignedInteger('bp_diastolic')->nullable(0)->change();
        });
    }
};
