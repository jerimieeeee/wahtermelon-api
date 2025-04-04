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
        Schema::table('consult_asrh_rapids', function (Blueprint $table) {
            $table->foreignId('lib_asrh_refusal_reason_id')->nullable(true)->after('refused_flag')->constrained();
            $table->string('refusal_reason_other')->nullable(true)->after('lib_asrh_refusal_reason_id');
            $table->foreignId('lib_asrh_living_arrangement_type_id')->nullable(true)->after('algorithm_remarks')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_asrh_rapids', function (Blueprint $table) {
            $table->dropForeign(['lib_asrh_refusal_reason_id']);
            $table->dropColumn('lib_asrh_refusal_reason_id');
            $table->dropColumn('refusal_reason_other');
            $table->dropForeign(['lib_asrh_living_arrangement_type_id']);
            $table->dropColumn('lib_asrh_living_arrangement_type_id');
        });
    }
};
