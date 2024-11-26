<?php

namespace App\Console\Commands;

use App\Models\V1\Barangay\SettingsBhs;
use App\Models\V1\Barangay\SettingsCatchmentBarangay;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use Doctrine\DBAL\Schema\MySQLSchemaManager;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        $tableNameHf = 'household_folders';
        $foreignKeyNameHf = 'household_folders_barangay_code_foreign';
        $referencedColumnNameHf = 'psgc_10_digit_code';

        $tableNameBhs = 'settings_bhs';
        $foreignKeyNameBhs = 'settings_bhs_barangay_code_foreign';
        $referencedColumnNameBhs = 'psgc_10_digit_code';

        $tableNameCb = 'settings_catchment_barangays';
        $foreignKeyNameCb = 'settings_catchment_barangays_barangay_code_foreign';
        $referencedColumnNameCb = 'psgc_10_digit_code';

        $tableNameMc = 'patient_mc_post_registrations';
        $foreignKeyNameMc = 'patient_mc_post_registrations_barangay_code_foreign';
        $referencedColumnNameMc = 'psgc_10_digit_code';

        $hf = $this->checkDatabase($tableNameHf, $foreignKeyNameHf, $referencedColumnNameHf);
        $sbhs = $this->checkDatabase($tableNameBhs, $foreignKeyNameBhs, $referencedColumnNameBhs);
        $scb = $this->checkDatabase($tableNameCb, $foreignKeyNameCb, $referencedColumnNameCb);
        $pmc = $this->checkDatabase($tableNameMc, $foreignKeyNameMc, $referencedColumnNameMc);



        $household = HouseholdFolder::query()->select('barangay_code')->first();
        $bhs = SettingsBhs::query()->select('barangay_code')->first();
        $catchment = SettingsCatchmentBarangay::query()->select('barangay_code')->first();
        $mc = PatientMcPostRegistration::query()->select('barangay_code')->first();
        $defaultIndex = 0;
        $name = $this->choice(
            'Select Module to Update Barangay Code',
            [
                'Update All',
                'Household Folder - ' . $hf . ' digit psgc code',
                'Settings BHS - ' . $sbhs . ' digit psgc code',
                'Settings Catchment Barangay - ' . $scb . ' digit psgc code',
                'Maternal Care - ' . $pmc . ' digit psgc code'
            ],
            $defaultIndex,
            $maxAttempts = null,
            $allowMultipleSelections = true
        );

        $updateAll = $this->searchArray($name, 'Update All');
        $updateHousehold = $this->searchArray($name, 'Household Folder');
        $updateBHS = $this->searchArray($name, 'Settings BHS');
        $updateCatchement = $this->searchArray($name, 'Settings Catchment Barangay');
        $updateMaternalCare = $this->searchArray($name, 'Maternal Care');

        //Household Folder
        if($updateAll || $updateHousehold) {
            $this->updateDatabaseTable($tableNameHf,$hf);
        }

        //Settings BHS
        if($updateAll || $updateBHS) {
            $this->updateDatabaseTable($tableNameBhs,$sbhs);
        }

        //Settings Catchment Barangay
        if($updateAll || $updateCatchement) {
            $this->updateDatabaseTable($tableNameCb,$scb);
        }

        //Patient Maternal Care
        if($updateAll || $updateMaternalCare) {
            $this->updateDatabaseTable($tableNameMc,$pmc);
        }
    }

    private function checkDatabase($tableName, $foreignKeyName, $referencedColumnName)
    {
        /*if (Schema::hasTable($tableName)) {
            $connection = Schema::getConnection();
            $schemaManager = $connection->getDoctrineSchemaManager();

            if ($schemaManager instanceof MySqlSchemaManager) {
                $foreignKeys = $schemaManager->listTableForeignKeys($tableName);

                foreach ($foreignKeys as $foreignKey) {
                    if ($foreignKey->getName() === $foreignKeyName) {
                        $referencedColumns = $foreignKey->getForeignColumns();
                        if (in_array($referencedColumnName, $referencedColumns)) {
                            return 10;
                        } elseif(in_array('code', $referencedColumns)) {
                            return 9;
                        } else{
                            echo "Referenced Column Name does not exist";
                        }
                        break;
                    }
                }
            } else {
                echo "Foreign key checks are only supported for MySQL databases.";
            }
        } else {
            echo "Table '$tableName' does not exist";
        }*/

        if (Schema::hasTable($tableName)) {
            $foreignKeys = Schema::getConnection()->getSchemaBuilder()->getForeignKeys($tableName);

            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey['name'] === $foreignKeyName) {
                    $referencedColumns = $foreignKey['foreign_columns'];
                    if (in_array($referencedColumnName, $referencedColumns)) {
                        return 10;
                    } elseif (in_array('code', $referencedColumns)) {
                        return 9;
                    } else {
                        return "Referenced Column Name does not exist";
                    }
                }
            }

            return "Foreign key '$foreignKeyName' not found.";
        } else {
            return "Table '$tableName' does not exist.";
        }
    }

    private function searchArray($array, $searchWord)
    {
        foreach ($array as $value) {
            if (Str::contains($value, $searchWord)) {
                return true;
                break; // If found, exit the loop
            }
        }
        return false;
    }

    private function updateDatabaseTable($table, $digit)
    {
        $newColumnName = ($digit === 9) ? "psgc_10_digit_code" : "old_barangay_code";
        $oldReferenceColumnName = ($digit === 9) ? "code" : "psgc_10_digit_code";
        $referenceColumnName = ($digit === 9) ? "psgc_10_digit_code" : "code";

        Schema::table($table, function (Blueprint $table) use ($newColumnName) {
            $table->string($newColumnName)->nullable()->after('barangay_code');
        });

        // Populate new column
        DB::statement("UPDATE $table t
               JOIN barangays b ON t.barangay_code = b.$oldReferenceColumnName
               SET t.$newColumnName = b.$referenceColumnName");

        // Remove old barangay_code column
        Schema::table($table, function ($table) use ($newColumnName, $referenceColumnName) {
            $table->dropForeign(['barangay_code']);
            $table->dropColumn('barangay_code');
            $table->renameColumn($newColumnName, 'barangay_code');
            $table->foreign('barangay_code')->references($referenceColumnName)->on('barangays');
        });
    }
}
