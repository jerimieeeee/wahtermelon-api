<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvOutcomeResult;
use Illuminate\Database\Seeder;

class LibGbvOutcomeResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvOutcomeResult::upsert([
            ['id' => 1, 'desc' => 'Unknown', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Acute medical problems resolved', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Patient died', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Psychiatric screening', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Psychiatric therapy completed', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Psychiatric therapy incomplete', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Case filed', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Perpetrator in jail', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Parents/guardians underwent rehabilitation/treatment', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Parents/guardians underwent couseling program', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Battered mother and partner reunited', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Battered mother separated from partner', 'sequence' => 12],
            ['id' => 13, 'desc' => 'Parents/guardians in support group', 'sequence' => 13],
            ['id' => 14, 'desc' => 'Parents/guardians involved in community-based NGO program', 'sequence' => 14],
            ['id' => 15, 'desc' => 'Employment/livelihood program for caregiver', 'sequence' => 15],
            ['id' => 16, 'desc' => 'Child in shelter', 'sequence' => 16],
            ['id' => 17, 'desc' => 'Child with relatives', 'sequence' => 17],
            ['id' => 18, 'desc' => 'Child back in school (Early childhood development program)', 'sequence' => 18],
            ['id' => 19, 'desc' => 'Child back in school (Daycare)', 'sequence' => 19],
            ['id' => 20, 'desc' => 'Child back in school (Regular school)', 'sequence' => 20],
            ['id' => 21, 'desc' => 'Child back in school (Special education)', 'sequence' => 21],
            ['id' => 22, 'desc' => 'Child reunited with family (Positive)', 'sequence' => 22],
            ['id' => 23, 'desc' => 'Child reunited with family (Negative)', 'sequence' => 23],
            ['id' => 24, 'desc' => 'Minor perpetrator underwent therapy', 'sequence' => 24],
            ['id' => 25, 'desc' => 'Other', 'sequence' => 25],
        ], ['id']);
    }
}
