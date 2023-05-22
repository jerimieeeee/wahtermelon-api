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
        Schema::table('patient_gbv_conferences', function (Blueprint $table) {
            $table->dropForeign(['patient_gbv_intake_id']);
            $table->dropColumn('patient_gbv_intake_id');

            $table->foreignUlid('patient_gbv_id')->after('facility_code')->index()->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_conferences', function (Blueprint $table) {
            $table->dropForeign(['patient_gbv_id']);
            $table->dropColumn('patient_gbv_id');

            $table->foreignUlid('patient_gbv_intake_id')->after('facility_code')->index()->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }
};
