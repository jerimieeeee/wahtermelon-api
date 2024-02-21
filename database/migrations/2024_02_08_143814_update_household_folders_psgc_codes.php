<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('household_folders', function ($table) {
            $table->string('psgc_10_digit_code')->nullable()->after('barangay_code');
        });

        // Populate psgc_10_digit_code column
        DB::statement('UPDATE household_folders hf
                       JOIN barangays b ON hf.barangay_code = b.code
                       SET hf.psgc_10_digit_code = b.psgc_10_digit_code');

        // Remove old barangay_code column
        Schema::table('household_folders', function ($table) {
            $table->dropForeign(['barangay_code']);
            $table->dropColumn('barangay_code');
            $table->renameColumn('psgc_10_digit_code', 'barangay_code');
            $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add the barangay_code column
        Schema::table('household_folders', function ($table) {
            $table->string('old_barangay_code')->nullable()->after('barangay_code');
        });

        // Populate barangay_code column if needed
        DB::statement('UPDATE household_folders hf
                       JOIN barangays b ON hf.barangay_code = b.psgc_10_digit_code
                       SET hf.old_barangay_code = b.code');
        // Remove the new psgc_10_digit_code column
        Schema::table('household_folders', function ($table) {
            $table->dropForeign(['barangay_code']);
            $table->dropColumn('barangay_code');
            $table->renameColumn('old_barangay_code', 'barangay_code');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });

        // Re-add foreign key constraint to use old column
//        Schema::table('household_folders', function ($table) {
//            $table->renameColumn('old_barangay_code', 'barangay_code');
//            $table->foreign('barangay_code')->references('code')->on('barangays');
//        });
    }
};
