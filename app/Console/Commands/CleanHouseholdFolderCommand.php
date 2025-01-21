<?php

namespace App\Console\Commands;

use App\Models\V1\Household\HouseholdFolder;
use Illuminate\Console\Command;

class CleanHouseholdFolderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'household:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    /* public function handle()
    {
        $householdFolder = HouseholdFolder::query()->whereDoesntHave('householdMember')->forceDelete();
        if (!$householdFolder) {
            $this->info('No Family folder to be deleted');
        } else {
            $this->info("Total of $householdFolder Family folders have been successfully deleted.");
        }
    } */
    public function handle()
    {
        // Retrieve all household folders without household members
        $householdFolders = HouseholdFolder::query()
            ->whereDoesntHave('householdMember')
            ->get();

        if ($householdFolders->isEmpty()) {
            $this->info('No Family folder to be deleted');
            return;
        }

        // Iterate through the folders and delete related records
        foreach ($householdFolders as $folder) {
            // Delete related records in household_environmentals
            $folder->householdEnvironmentals()->delete();

            // Force delete the folder
            $folder->forceDelete();
        }

        $this->info("Total of {$householdFolders->count()} Family folders have been successfully deleted.");
    }
}
