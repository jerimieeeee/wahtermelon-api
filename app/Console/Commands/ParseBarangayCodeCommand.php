<?php

namespace App\Console\Commands;

use App\Models\V1\Barangay\SettingsBhs;
use App\Models\V1\Barangay\SettingsCatchmentBarangay;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ParseBarangayCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barangay-code:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Household Folder
        $household = HouseholdFolder::query()->select('barangay_code')->first();
        if(!empty($household) && is_string($household->barangay_code) && strlen($household->barangay_code) === 9) {
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
        if(!empty($household) && is_string($household->barangay_code) && strlen($household->barangay_code) === 10) {
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
        }

        //Settings BHS
        $bhs = SettingsBhs::query()->select('barangay_code')->first();
        if(!empty($bhs) && is_string($bhs->barangay_code) && strlen($bhs->barangay_code) === 9) {
            Schema::table('settings_bhs', function (Blueprint $table) {
                $table->string('psgc_10_digit_code')->nullable()->after('barangay_code');
            });

            // Populate psgc_10_digit_code column
            DB::statement('UPDATE settings_bhs bhs
                       JOIN barangays b ON bhs.barangay_code = b.code
                       SET bhs.psgc_10_digit_code = b.psgc_10_digit_code');

            // Remove old barangay_code column
            Schema::table('settings_bhs', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('psgc_10_digit_code', 'barangay_code');
                $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
            });
        }
        if(!empty($bhs) && is_string($bhs->barangay_code) && strlen($bhs->barangay_code) === 10) {
            Schema::table('settings_bhs', function (Blueprint $table) {
                $table->string('old_barangay_code')->nullable()->after('barangay_code');
            });

            // Populate barangay_code column if needed
            DB::statement('UPDATE settings_bhs bhs
                       JOIN barangays b ON bhs.barangay_code = b.psgc_10_digit_code
                       SET bhs.old_barangay_code = b.code');
            // Remove the new psgc_10_digit_code column
            Schema::table('settings_bhs', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('old_barangay_code', 'barangay_code');
                $table->foreign('barangay_code')->references('code')->on('barangays');
            });
        }

        //Settings Catchment Barangay
        $catchment = SettingsCatchmentBarangay::query()->select('barangay_code')->first();
        if(!empty($catchment) && is_string($catchment->barangay_code) && strlen($catchment->barangay_code) === 9) {
            Schema::table('settings_catchment_barangays', function (Blueprint $table) {
                $table->string('psgc_10_digit_code')->nullable()->after('barangay_code');
            });

            // Populate psgc_10_digit_code column
            DB::statement('UPDATE settings_catchment_barangays catchment
                           JOIN barangays b ON catchment.barangay_code = b.code
                           SET catchment.psgc_10_digit_code = b.psgc_10_digit_code');

            // Remove old barangay_code column
            Schema::table('settings_catchment_barangays', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('psgc_10_digit_code', 'barangay_code');
                $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
            });
        }
        if(!empty($catchment) && is_string($catchment->barangay_code) && strlen($catchment->barangay_code) === 10) {
            Schema::table('settings_catchment_barangays', function (Blueprint $table) {
                $table->string('old_barangay_code')->nullable()->after('barangay_code');
            });

            // Populate barangay_code column if needed
            DB::statement('UPDATE settings_catchment_barangays catchment
                       JOIN barangays b ON catchment.barangay_code = b.psgc_10_digit_code
                       SET catchment.old_barangay_code = b.code');
            // Remove the new psgc_10_digit_code column
            Schema::table('settings_catchment_barangays', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('old_barangay_code', 'barangay_code');
                $table->foreign('barangay_code')->references('code')->on('barangays');
            });
        }

        //Patient Maternal Care
        $mc = PatientMcPostRegistration::query()->select('barangay_code')->first();
        if(!empty($mc) && is_string($mc->barangay_code) && strlen($mc->barangay_code) === 9) {
            Schema::table('patient_mc_post_registrations', function (Blueprint $table) {
                $table->string('psgc_10_digit_code')->nullable()->after('barangay_code');
            });

            // Populate psgc_10_digit_code column
            DB::statement('UPDATE patient_mc_post_registrations mc
                       JOIN barangays b ON mc.barangay_code = b.code
                       SET mc.psgc_10_digit_code = b.psgc_10_digit_code');

            // Remove old barangay_code column
            Schema::table('patient_mc_post_registrations', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('psgc_10_digit_code', 'barangay_code');
                $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
            });
        }
        if(!empty($mc) && is_string($mc->barangay_code) && strlen($mc->barangay_code) === 10) {
            Schema::table('patient_mc_post_registrations', function (Blueprint $table) {
                $table->string('old_barangay_code')->nullable()->after('barangay_code');
            });

            // Populate barangay_code column if needed
            DB::statement('UPDATE patient_mc_post_registrations mc
                       JOIN barangays b ON mc.barangay_code = b.psgc_10_digit_code
                       SET mc.old_barangay_code = b.code');
            // Remove the new psgc_10_digit_code column
            Schema::table('patient_mc_post_registrations', function ($table) {
                $table->dropForeign(['barangay_code']);
                $table->dropColumn('barangay_code');
                $table->renameColumn('old_barangay_code', 'barangay_code');
                $table->foreign('barangay_code')->references('code')->on('barangays');
            });
        }
    }
}
