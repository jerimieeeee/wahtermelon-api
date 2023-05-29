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
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->boolean('child_abuse_physical_flag')->after('child_abuse_sexual_flag')->nullable();
            $table->boolean('child_abuse_emotional_flag')->after('child_abuse_physical_flag')->nullable();
            $table->boolean('child_abuse_economic_flag')->after('child_abuse_emotional_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->dropColumn('child_abuse_physical_flag');
            $table->dropColumn('child_abuse_emotional_flag');
            $table->dropColumn('child_abuse_economic_flag');
        });
    }
};
