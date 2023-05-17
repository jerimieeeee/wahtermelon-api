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
            $table->boolean('same_address_flag')->after('economic_status_id')->nullable();
            $table->boolean('vaw_physical_flag')->after('present_living_arrangement_remarks')->nullable();
            $table->boolean('vaw_sexual_flag')->after('vaw_physical_flag')->nullable();
            $table->boolean('vaw_psychological_flag')->after('vaw_sexual_flag')->nullable();
            $table->boolean('vaw_economic_flag')->after('vaw_psychological_flag')->nullable();

            $table->boolean('rape_sex_intercourse_flag')->after('vaw_economic_flag')->nullable();
            $table->boolean('rape_sex_assault_flag')->after('rape_sex_intercourse_flag')->nullable();
            $table->boolean('rape_incest_flag')->after('rape_sex_assault_flag')->nullable();
            $table->boolean('rape_statutory_flag')->after('rape_incest_flag')->nullable();
            $table->boolean('rape_marital_flag')->after('rape_statutory_flag')->nullable();

            $table->boolean('harassment_verbal_flag')->after('rape_marital_flag')->nullable();
            $table->boolean('harassment_physical_flag')->after('harassment_verbal_flag')->nullable();
            $table->boolean('harassment_object_flag')->after('harassment_physical_flag')->nullable();

            $table->boolean('child_abuse_engaged_flag')->after('harassment_object_flag')->nullable();
            $table->boolean('child_abuse_sexual_flag')->after('child_abuse_engaged_flag')->nullable();
            $table->string('wcpd_others')->after('child_abuse_sexual_flag')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->dropColumn('same_address_flag');
            $table->dropColumn('vaw_physical_flag');
            $table->dropColumn('vaw_sexual_flag');
            $table->dropColumn('vaw_psychological_flag');
            $table->dropColumn('vaw_economic_flag');
            $table->dropColumn('rape_sex_intercourse_flag');
            $table->dropColumn('rape_sex_assault_flag');
            $table->dropColumn('rape_incest_flag');
            $table->dropColumn('rape_statutory_flag');
            $table->dropColumn('rape_marital_flag');
            $table->dropColumn('harassment_verbal_flag');
            $table->dropColumn('harassment_physical_flag');
            $table->dropColumn('harassment_object_flag');
            $table->dropColumn('child_abuse_engaged_flag');
            $table->dropColumn('child_abuse_sexual_flag');
            $table->dropColumn('wcpd_others');
        });
    }
};
