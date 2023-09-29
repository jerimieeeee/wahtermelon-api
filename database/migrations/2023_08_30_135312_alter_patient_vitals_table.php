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
        Schema::table('patient_vitals', function (Blueprint $table) {
            $table->integer('patient_left_vision_acuity_distance')->after('patient_muac')->nullable();
            $table->integer('patient_right_vision_acuity_distance')->after('patient_left_vision_acuity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_vitals', function (Blueprint $table) {
            $table->dropColumn('patient_left_vision_acuity_distance');
            $table->dropColumn('patient_right_vision_acuity_distance');
        });
    }
};
