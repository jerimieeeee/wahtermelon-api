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
        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_family_compositions_patient_gbv_intake_id_foreign');
            $table->dropColumn('patient_gbv_intake_id');
        });

        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_id')->after('facility_code')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->dropForeign('patient_gbv_family_compositions_patient_gbv_id_foreign');
            $table->dropColumn('patient_gbv_id');
        });

        Schema::table('patient_gbv_family_compositions', function (Blueprint $table) {
            $table->foreignUlid('patient_gbv_intake_id')->after('facility_code')->constrained();
        });
    }
};
