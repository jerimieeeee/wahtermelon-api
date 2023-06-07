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
        Schema::table('patient_gbv_social_works', function (Blueprint $table) {
            $table->string('social_worker_remarks')->after('social_worker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_social_works', function (Blueprint $table) {
            $table->dropColumn('social_worker_remarks');
        });
    }
};
