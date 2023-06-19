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
        Schema::table('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->text('pe_head_and_neck_remarks')->nullable()->after('gbv_general_survey_remarks');
            $table->text('pe_chest_and_lungs_remarks')->nullable()->after('pe_head_and_neck_remarks');
            $table->text('pe_breast_remarks')->nullable()->after('pe_chest_and_lungs_remarks');
            $table->text('pe_abdomen_remarks')->nullable()->after('pe_breast_remarks');
            $table->text('pe_back_remarks')->nullable()->after('pe_abdomen_remarks');
            $table->text('pe_extremities_remarks')->nullable()->after('pe_back_remarks');
            $table->text('pe_anogenital_remarks')->nullable()->after('pe_extremities_remarks');
            $table->text('pe_external_genitalia_remarks')->nullable()->after('pe_anogenital_remarks');
            $table->text('pe_anus_remarks')->nullable()->after('pe_external_genitalia_remarks');
            $table->text('pe_hymen_remarks')->nullable()->after('pe_anus_remarks');
            $table->foreignId('medical_impression_id')->nullable()->after('pe_hymen_remarks')->on('lib_gbv_medical_impressions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_medical_histories', function (Blueprint $table) {
            $table->dropColumn('pe_head_and_neck_remarks');
            $table->dropColumn('pe_chest_and_lungs_remarks');
            $table->dropColumn('pe_breast_remarks');
            $table->dropColumn('pe_abdomen_remarks');
            $table->dropColumn('pe_back_remarks');
            $table->dropColumn('pe_extremities_remarks');
            $table->dropColumn('pe_anogenital_remarks');
            $table->dropColumn('pe_external_genitalia_remarks');
            $table->dropColumn('pe_anus_remarks');
            $table->dropColumn('pe_hymen_remarks');

            $table->dropColumn('medical_impression_id');
        });
        Schema::enableForeignKeyConstraints();
    }
};
