<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvOutcomeReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvOutcomeReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvOutcomeReason::upsert([
            ['desc' => 'Client refuses services/requests closure', 'sequence' => 1],
            ['desc' => 'Need for service not established', 'sequence' => 2],
            ['desc' => 'Completion of service', 'sequence' => 3],
            ['desc' => 'Unable to locate client', 'sequence' => 4],
            ['desc' => 'Patient is dead', 'sequence' => 5],
            ['desc' => 'Child endorsed to shelter', 'sequence' => 6],
            ['desc' => 'Endorsed to DSWD or LGU', 'sequence' => 7],
            ['desc' => 'Other', 'sequence' => 8],
        ], ['id']);
    }
}
