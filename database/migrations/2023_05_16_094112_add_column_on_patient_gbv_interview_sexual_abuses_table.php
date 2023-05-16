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
        Schema::table('patient_gbv_interview_sexual_abuses', function (Blueprint $table) {
            $table->foreignId('info_source_id')->after('intake_id')->nullable()->constrained('lib_gbv_info_sources');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interview_sexual_abuses', function (Blueprint $table) {
            $table->dropForeign(['info_source_id']);
            $table->dropColumn('info_source_id');
        });
    }
};
