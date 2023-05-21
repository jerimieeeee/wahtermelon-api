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
            $table->string('outcome_remarks')->after('outcome_verdict_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->dropColumn('outcome_remarks');
        });
    }
};
