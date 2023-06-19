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
        Schema::table('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->text('medical_impression_remarks')->nullable()->after('medical_impression_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->dropColumn('medical_impression_remarks');
        });
    }
};
