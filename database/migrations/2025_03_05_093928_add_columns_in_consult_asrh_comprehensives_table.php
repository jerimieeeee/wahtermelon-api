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
        Schema::table('consult_asrh_comprehensives', function (Blueprint $table) {
            $table->boolean('self_harm')->default(false)->nullable()->after('risky_behavior');
            $table->foreignId('lib_asrh_consent_type_id')->nullable(true)->after('consent_flag')->constrained();
            $table->foreignId('lib_asrh_refusal_reason_id')->nullable(true)->after('refused_flag')->constrained();
            $table->string('consent_type_other')->nullable(true)->after('lib_asrh_consent_type_id');
            $table->string('refusal_reason_other')->nullable(true)->after('lib_asrh_refusal_reason_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_asrh_comprehensives', function (Blueprint $table) {
            $table->dropColumn('self_harm');
            $table->dropForeign(['lib_asrh_consent_type_id']);
            $table->dropColumn('lib_asrh_consent_type_id');
            $table->dropForeign(['lib_asrh_refusal_reason_id']);
            $table->dropColumn('lib_asrh_refusal_reason_id');
            $table->dropColumn('consent_type_other');
            $table->dropColumn('refusal_reason_other');
        });
    }
};
