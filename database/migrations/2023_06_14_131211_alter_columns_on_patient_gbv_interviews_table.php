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
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropForeign(['child_behavior_id']);
            $table->dropColumn('child_behavior_id');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->foreignId('child_behavior_id')->nullable()->after('relation_to_child')->constrained('lib_gbv_child_behaviors');
        });
    }
};
