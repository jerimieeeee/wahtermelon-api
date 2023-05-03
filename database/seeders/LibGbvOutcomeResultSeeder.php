<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvOutcomeResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvOutcomeResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvOutcomeResult::upsert([
            ['desc' => 'Unknown', 'sequence' => 1],
            ['desc' => 'Acute medical problems resolved', 'sequence' => 2],
            ['desc' => 'Patient died', 'sequence' => 3],
            ['desc' => 'Psychiatric screening', 'sequence' => 4],
            ['desc' => 'Psychiatric therapy completed', 'sequence' => 5],
            ['desc' => 'Psychiatric therapy incomplete', 'sequence' => 6],
            ['desc' => 'Case filed', 'sequence' => 7],
            ['desc' => 'Perpetrator in jail', 'sequence' => 8],
            ['desc' => 'Parents/guardians underwent rehabilitation/treatment', 'sequence' => 9],
            ['desc' => 'Parents/guardians underwent couseling program', 'sequence' => 10],
            ['desc' => 'Battered mother and partner reunited', 'sequence' => 11],
            ['desc' => 'Battered mother separated from partner', 'sequence' => 12],
            ['desc' => 'Parents/guardians in support group', 'sequence' => 13],
            ['desc' => 'Parents/guardians involved in community-based NGO program', 'sequence' => 14],
            ['desc' => 'Employment/livelihood program for caregiver', 'sequence' => 15],
            ['desc' => 'Child in shelter', 'sequence' => 16],
            ['desc' => 'Child with relatives', 'sequence' => 17],
            ['desc' => 'Child back in school (Early childhood development program)', 'sequence' => 18],
            ['desc' => 'Child back in school (Daycare)', 'sequence' => 19],
            ['desc' => 'Child back in school (Regular school)', 'sequence' => 20],
            ['desc' => 'Child back in school (Special education)', 'sequence' => 21],
            ['desc' => 'Child reunited with family (Positive)', 'sequence' => 22],
            ['desc' => 'Child reunited with family (Negative)', 'sequence' => 23],
            ['desc' => 'Minor perpetrator underwent therapy', 'sequence' => 24],
            ['desc' => 'Other', 'sequence' => 25],
        ], ['id']);
    }
}
