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
    public function handle()
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
    }
}
