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
            ['id' => 1, 'desc' => 'Child in safe home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Child with relative or well placed', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Perpetrator access barred', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Perpetrator jailed, fled', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Family supportive of child', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Child coping with abuse', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Child attends therapy', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Child is healthy, happy', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Others', 'sequence' => 9],
        ], ['id']);
    }
}
