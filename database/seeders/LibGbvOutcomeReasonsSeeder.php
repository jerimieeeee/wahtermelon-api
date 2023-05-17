<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvOutcomeReason;
use Illuminate\Database\Seeder;

class LibGbvOutcomeReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvOutcomeReason::upsert([
            ['id' => 1, 'desc' => 'Not a GBV Case', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Client refuses services/requests closure', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Need for service not established', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Completion of service', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Unable to locate client', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Patient is dead', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Child endorsed to shelter', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Endorsed to DSWD or LGU', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Other', 'sequence' => 9],
        ], ['id']);
    }
}
