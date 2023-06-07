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
        Schema::table('patient_gbv_legal_cases', function (Blueprint $table) {
            $table->foreignId('filing_type_id')->after('complaint_filed_flag')->constrained('lib_gbv_filing_types');
            $table->string('nps_docket_number')->after('filing_type_id')->nullable();
            $table->foreignId('nps_status_id')->after('nps_docket_number')->constrained('lib_gbv_nps_statuses');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_legal_cases', function (Blueprint $table) {
            $table->dropForeign(['filing_type_id']);
            $table->dropColumn('filing_type_id');
            $table->dropColumn('nps_docket_number');
            $table->dropForeign(['nps_status_id']);
            $table->dropColumn('nps_status_id');
        });
        Schema::enableForeignKeyConstraints();
    }
};
