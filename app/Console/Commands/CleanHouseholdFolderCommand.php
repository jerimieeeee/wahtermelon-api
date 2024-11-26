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
    public function handle()
    {
        $householdFolder = HouseholdFolder::query()->whereDoesntHave('householdMember')->forceDelete();
        if (!$householdFolder) {
            $this->info('No Family folder to be deleted');
        } else {
            $this->info("Total of $householdFolder Family folders have been successfully deleted.");
        }
    }
}
