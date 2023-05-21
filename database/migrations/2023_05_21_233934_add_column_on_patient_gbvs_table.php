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
            $table->string('outcome_reason_remarks')->after('outcome_reason_id')->nullable();
            $table->string('outcome_result_remarks')->after('outcome_result_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->dropColumn('outcome_reason_remarks');
            $table->dropColumn('outcome_result_remarks');
        });
    }
};
