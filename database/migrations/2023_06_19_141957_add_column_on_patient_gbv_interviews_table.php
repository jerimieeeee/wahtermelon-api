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
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->string('source_from_historian_remarks')->nullable()->after('source_from_historian_flag');

            $table->boolean('behavior_historian_cooperative_flag')->after('child_behavior_remarks')->default(0);
            $table->boolean('behavior_historian_crying_flag')->after('behavior_historian_cooperative_flag')->default(0);
            $table->boolean('behavior_historian_clinging_flag')->after('behavior_historian_crying_flag')->default(0);
            $table->boolean('behavior_historian_responsive_flag')->after('behavior_historian_clinging_flag')->default(0);
            $table->boolean('behavior_historian_silent_flag')->after('behavior_historian_responsive_flag')->default(0);
            $table->boolean('behavior_historian_able_to_narrate_flag')->after('behavior_historian_silent_flag')->default(0);
            $table->boolean('behavior_historian_unable_to_narrate_flag')->after('behavior_historian_able_to_narrate_flag')->default(0);
            $table->boolean('behavior_historian_appropriate_affect_flag')->after('behavior_historian_unable_to_narrate_flag')->default(0);
            $table->boolean('behavior_historian_depressed_affect_flag')->after('behavior_historian_appropriate_affect_flag')->default(0);
            $table->boolean('behavior_historian_flat_affect_flag')->after('behavior_historian_depressed_affect_flag')->default(0);
            $table->boolean('behavior_historian_psychotic_flag')->after('behavior_historian_flat_affect_flag')->default(0);
            $table->boolean('behavior_historian_combative_flag')->after('behavior_historian_psychotic_flag')->default(0);
            $table->boolean('behavior_historian_hyperactive_flag')->after('behavior_historian_combative_flag')->default(0);
            $table->boolean('behavior_historian_short_attention_flag')->after('behavior_historian_hyperactive_flag')->default(0);
            $table->boolean('behavior_historian_remarks')->after('behavior_historian_short_attention_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('source_from_historian_remarks');

            $table->dropColumn('behavior_historian_cooperative_flag');
            $table->dropColumn('behavior_historian_crying_flag');
            $table->dropColumn('behavior_historian_clinging_flag');
            $table->dropColumn('behavior_historian_responsive_flag');
            $table->dropColumn('behavior_historian_silent_flag');
            $table->dropColumn('behavior_historian_able_to_narrate_flag');
            $table->dropColumn('behavior_historian_unable_to_narrate_flag');
            $table->dropColumn('behavior_historian_appropriate_affect_flag');
            $table->dropColumn('behavior_historian_depressed_affect_flag');
            $table->dropColumn('behavior_historian_flat_affect_flag');
            $table->dropColumn('behavior_historian_psychotic_flag');
            $table->dropColumn('behavior_historian_combative_flag');
            $table->dropColumn('behavior_historian_hyperactive_flag');
            $table->dropColumn('behavior_historian_short_attention_flag');
            $table->dropColumn('behavior_historian_remarks');
        });
    }
};
