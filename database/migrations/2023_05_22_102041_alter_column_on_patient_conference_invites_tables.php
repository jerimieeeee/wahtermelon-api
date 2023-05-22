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
        Schema::table('patient_gbv_conference_invites', function (Blueprint $table) {
            $table->dropForeign(['patient_gbv_conference_id']);
            $table->dropColumn('patient_gbv_conference_id');

            $table->foreignUlid('conference_id')->after('facility_code')->constrained('patient_gbv_conferences');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_conference_invites', function (Blueprint $table) {
            $table->dropForeign(['conference_id']);
            $table->dropColumn('conference_id');

            $table->foreignUlid('patient_gbv_conference_id')->after('facility_code')->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }
};
