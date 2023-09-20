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
        Schema::table('patient_ab_post_exposures', function (Blueprint $table) {
            $table->dropColumn('booster_1_flag');
            $table->dropColumn('booster_2_flag');

            $table->date('booster1_date')->nullable()->after('rig_date');
            $table->string('booster1_vaccine_code')->nullable()->after('booster1_date');
            $table->char('booster1_vaccine_route_code', 2)->nullable()->after('booster1_vaccine_code');

            $table->date('booster2_date')->nullable()->after('booster1_vaccine_route_code');
            $table->string('booster2_vaccine_code')->nullable()->after('booster2_date');
            $table->char('booster2_vaccine_route_code', 2)->nullable()->after('booster2_vaccine_code');

            $table->foreign('booster1_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('booster1_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('booster2_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('booster2_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_ab_post_exposures', function (Blueprint $table) {
            $table->boolean('booster_1_flag')->default(false)->after('rig_date');
            $table->boolean('booster_2_flag')->default(false)->after('booster_1_flag');

            $table->dropColumn('booster1_date');
            $table->dropColumn('booster1_vaccine_code');
            $table->dropColumn('booster1_vaccine_route_code', 2);

            $table->dropColumn('booster2_date');
            $table->dropColumn('booster2_vaccine_code');
            $table->dropColumn('booster2_vaccine_route_code', 2);
        });
    }
};
