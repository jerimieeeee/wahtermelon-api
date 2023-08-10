<?php

namespace App\Console\Commands;

use App\Models\V1\Household\HouseholdMember;
use Illuminate\Console\Command;

class RemoveHouseholdMemberDuplicateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'household-member:duplicate-remove';

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
        $householdMember = new HouseholdMember;
        $householdMemberTableName = $householdMember->getTable();

        do {
            // Retrieve the duplicate records
            $duplicateRecords = $householdMember->whereIn('id', function ($query) use ($householdMemberTableName) {
                $query->select('id')
                    ->from(function ($subquery) use ($householdMemberTableName) {
                        $subquery->selectRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY created_at DESC), ',', 1), ',', -1) AS id")
                            ->from($householdMemberTableName)
                            ->groupBy('patient_id')
                            ->havingRaw('count(patient_id) > 1');
                    });
            })->get();

            if ($duplicateRecords->count() > 0) {
                // Delete the duplicate records
                $householdMember->whereIn('id', $duplicateRecords->pluck('id'))->forceDelete();
            }
        } while ($duplicateRecords->count() > 0);
    }
}
