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
            $table->decimal('patient_resp_rate', 10, 2)->nullable()->after('patient_heart_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->dropColumn('patient_resp_rate');
        });
    }
};
