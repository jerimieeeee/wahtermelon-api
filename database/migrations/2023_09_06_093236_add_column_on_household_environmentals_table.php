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
        Schema::table('household_environmentals', function (Blueprint $table) {
            $table->dropForeign(['waste_management_code']);
            $table->dropColumn('waste_management_code');
            $table->dropForeign(['sewage_code']);
            $table->dropColumn('sewage_code');

            $table->boolean('sw_disposed_flag')->default(false)->after('toilet_shared_flag');
            $table->boolean('sw_collected_flag')->default(false)->after('sw_disposed_flag');

            $table->boolean('wm_waste_segration_flag')->default(false)->after('sw_collected_flag');
            $table->boolean('wm_backyad_composting_flag')->default(false)->after('wm_waste_segration_flag');
            $table->boolean('wm_recycling_flag')->default(false)->after('wm_backyad_composting_flag');
            $table->boolean('wm_collected_flag')->default(false)->after('wm_recycling_flag');
            $table->boolean('wm_others_flag')->default(false)->after('wm_collected_flag');
            $table->string('wm_others_remarks')->nullable()->after('wm_others_flag');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('household_environmentals', function (Blueprint $table) {
            $table->unsignedBigInteger('waste_management_code')->constrained();
            $table->foreign('waste_management_code')->references('code')->on('lib_environmental_waste_management');

            $table->dropColumn('sw_disposed_flag');
            $table->dropColumn('sw_collected_flag');
            $table->dropColumn('wm_waste_segration_flag');
            $table->dropColumn('wm_backyad_composting_flag');
            $table->dropColumn('wm_recycling_flag');
            $table->dropColumn('wm_collected_flag');
            $table->dropColumn('wm_others_flag');
            $table->dropColumn('wm_others_remarks');
        });
        Schema::enableForeignKeyConstraints();
    }
};
