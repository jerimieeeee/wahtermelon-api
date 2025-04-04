<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckFacilityCodeColumnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:facility-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all tables in the database for the presence of the facility_code column';

    /**
     * Execute the console command.
     */
    /* public function handle()
    {
        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Loop through each table
        foreach ($tables as $table) {
            $tableName = reset($table); // Get the table name

            // Check if the table has the 'facility_code' column
            if (Schema::hasColumn($tableName, 'facility_code')) {
                $this->info("Table `{$tableName}` has the `facility_code` column.");
            } else {
                $this->line("Table `{$tableName}` does not have the `facility_code` column.");
            }
        }

        $this->info('Finished checking all tables.');
    } */
    public function handle()
    {
        // Ask for the old facility code value and validate it
        $oldFacilityCode = $this->askAndValidateFacilityCode('Enter the old facility code value:', 'old');

        // If validation fails, stop the command
        if (!$oldFacilityCode) {
            $this->error('Command stopped.');
            return;
        }

        // Ask for the new facility code value and validate it
        $newFacilityCode = $this->askAndValidateFacilityCode('Enter the new facility code value:', 'new');

        // If validation fails, stop the command
        if (!$newFacilityCode) {
            $this->error('Command stopped.');
            return;
        }

        // Confirm the action
        if (!$this->confirm("Are you sure you want to update `facility_code` from `{$oldFacilityCode}` to `{$newFacilityCode}` in all tables?")) {
            $this->error('Update canceled.');
            return;
        }

        // Initialize an array to store the summary report
        $summaryReport = [];

        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Loop through each table
        foreach ($tables as $table) {
            $tableName = reset($table); // Get the table name

            // Check if the table has the 'facility_code' column
            if (Schema::hasColumn($tableName, 'facility_code')) {
                $this->info("Table `{$tableName}` has the `facility_code` column.");

                // Update the facility_code value from old to new
                $updatedRows = DB::table($tableName)
                    ->where('facility_code', $oldFacilityCode)
                    ->update(['facility_code' => $newFacilityCode]);

                // Add the result to the summary report
                $summaryReport[] = [
                    'table' => $tableName,
                    'updated_rows' => $updatedRows,
                ];

                $this->info("Updated {$updatedRows} rows in `{$tableName}`.");
            } else {
                $this->line("Table `{$tableName}` does not have the `facility_code` column.");
            }
        }

        // Display the summary report
        $this->info("\nSummary Report:");
        $this->table(['Table', 'Updated Rows'], $summaryReport);

        $this->info('Finished checking and updating all tables.');
    }

    /**
     * Ask for a facility code and validate it.
     *
     * @param string $question The question to ask.
     * @param string $type The type of facility code (old or new).
     * @return string|null The validated facility code or null if invalid.
     */
    protected function askAndValidateFacilityCode($question, $type)
    {
        // Keep asking until a valid facility code is provided or the user cancels
        while (true) {
            $facilityCode = $this->ask($question);

            if ($type === 'old') {
                return $facilityCode;
            }

            // Validate the facility code
            if ($this->validateFacilityCode($facilityCode, $type)) {
                return $facilityCode;
            }

            // Ask if the user wants to try again
            if (!$this->confirm('Do you want to try again?')) {
                return null;
            }
        }
    }

    /**
     * Validate that the facility code exists in the `facilities` table.
     *
     * @param string $facilityCode The facility code to validate.
     * @param string $type The type of facility code (old or new).
     * @return bool
     */
    protected function validateFacilityCode($facilityCode, $type)
    {
        // Check if the facility code exists in the `facilities` table
        $exists = DB::table('facilities')
            ->where('code', $facilityCode)
            ->exists();

        if (!$exists) {
            $this->error("The {$type} facility code `{$facilityCode}` does not exist in the `facilities` table.");
            return false;
        }

        $this->info("The {$type} facility code `{$facilityCode}` is valid.");
        return true;
    }
}
