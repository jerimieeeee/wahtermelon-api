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
            $table->boolean('behavior_cooperative_flag')->after('relation_to_child')->default(0);
            $table->boolean('behavior_crying_flag')->after('behavior_cooperative_flag')->default(0);
            $table->boolean('behavior_clinging_flag')->after('behavior_crying_flag')->default(0);
            $table->boolean('behavior_responsive_flag')->after('behavior_clinging_flag')->default(0);
            $table->boolean('behavior_silent_flag')->after('behavior_responsive_flag')->default(0);
            $table->boolean('behavior_able_to_narrate_flag')->after('behavior_silent_flag')->default(0);
            $table->boolean('behavior_unable_to_narrate_flag')->after('behavior_able_to_narrate_flag')->default(0);
            $table->boolean('behavior_appropriate_affect_flag')->after('behavior_unable_to_narrate_flag')->default(0);
            $table->boolean('behavior_depressed_affect_flag')->after('behavior_appropriate_affect_flag')->default(0);
            $table->boolean('behavior_flat_affect_flag')->after('behavior_depressed_affect_flag')->default(0);
            $table->boolean('behavior_psychotic_flag')->after('behavior_flat_affect_flag')->default(0);
            $table->boolean('behavior_combative_flag')->after('behavior_psychotic_flag')->default(0);
            $table->boolean('behavior_hyperactive_flag')->after('behavior_combative_flag')->default(0);
            $table->boolean('behavior_short_attention_flag')->after('behavior_hyperactive_flag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropColumn('behavior_cooperative_flag');
            $table->dropColumn('behavior_crying_flag');
            $table->dropColumn('behavior_clinging_flag');
            $table->dropColumn('behavior_responsive_flag');
            $table->dropColumn('behavior_silent_flag');
            $table->dropColumn('behavior_able_to_narrate_flag');
            $table->dropColumn('behavior_unable_to_narrate_flag');
            $table->dropColumn('behavior_appropriate_affect_flag');
            $table->dropColumn('behavior_depressed_affect_flag');
            $table->dropColumn('behavior_flat_affect_flag');
            $table->dropColumn('behavior_psychotic_flag');
            $table->dropColumn('behavior_combative_flag');
            $table->dropColumn('behavior_hyperactive_flag');
            $table->dropColumn('behavior_short_attention_flag');
        });
    }
};
