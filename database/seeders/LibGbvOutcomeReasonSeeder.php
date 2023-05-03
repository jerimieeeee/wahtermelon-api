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
            ['id' => 1, 'desc' => 'Client refuses services/requests closure', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Need for service not established', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Completion of service', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Unable to locate client', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Patient is dead', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Child endorsed to shelter', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Endorsed to DSWD or LGU', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Other', 'sequence' => 8],
        ], ['id']);
    }
}
