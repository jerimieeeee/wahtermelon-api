<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvConferenceMitigatingFactor;
use Illuminate\Database\Seeder;

class LibGbvConferenceMitigatingFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvConferenceMitigatingFactor::upsert([
            ['id' => 1, 'desc' => 'Victim survivor in safe home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Victim survivor with relative or well placed', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Perpetrator access barred', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Perpetrator jailed, fled', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Family supportive of victim survivor', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Victim survivor coping with abuse', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Victim survivor attends therapy', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Victim survivor is healthy, happy', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Others', 'sequence' => 9],
        ], ['id']);
    }
}
