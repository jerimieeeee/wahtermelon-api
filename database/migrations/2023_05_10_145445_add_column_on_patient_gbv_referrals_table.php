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
        Schema::table('patient_gbv_referrals', function (Blueprint $table) {
            $table->boolean('referral_remarks')->nullable()->after('service_remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_referrals', function (Blueprint $table) {
            $table->dropColumn('referral_remarks');
        });
    }
};
