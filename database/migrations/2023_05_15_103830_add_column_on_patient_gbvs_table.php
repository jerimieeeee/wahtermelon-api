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
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->date('gbv_date')->after('facility_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->dropColumn('gbv_date');
        });
    }
};
