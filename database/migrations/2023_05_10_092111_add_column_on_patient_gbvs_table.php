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
            $table->boolean('physical_abuse_flag')->nullable()->after('primary_complaint_remarks');
            $table->boolean('sexual_abuse_flag')->nullable()->after('physical_abuse_flag');
            $table->boolean('neglect_abuse_flag')->nullable()->after('sexual_abuse_flag');
            $table->boolean('emotional_abuse_flag')->nullable()->after('neglect_abuse_flag');
            $table->boolean('economic_abuse_flag')->nullable()->after('emotional_abuse_flag');
            $table->boolean('utv_abuse_flag')->nullable()->after('economic_abuse_flag');
            $table->boolean('others_abuse_flag')->nullable()->after('utv_abuse_flag');
            $table->string('others_abuse_remarks', '255')->nullable()->after('others_abuse_flag');
            $table->boolean('incest_case_flag')->nullable()->after('number_of_family');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbvs', function (Blueprint $table) {
            $table->dropColumn('physical_abuse_flag');
            $table->dropColumn('sexual_abuse_flag');
            $table->dropColumn('neglect_abuse_flag');
            $table->dropColumn('emotional_abuse_flag');
            $table->dropColumn('economic_abuse_flag');
            $table->dropColumn('utv_abuse_flag');
            $table->dropColumn('others_abuse_flag');
            $table->dropColumn('others_abuse_remarks');
            $table->dropColumn('incest_case_flag');
        });
    }
};
