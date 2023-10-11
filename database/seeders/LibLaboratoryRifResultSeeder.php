<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryRifResult;
use Illuminate\Database\Seeder;

class LibLaboratoryRifResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryRifResult::upsert([
            ['code' => 'NA', 'desc' => 'Not Applicable'],
            ['code' => 'RND', 'desc' => 'RIF-Resistance Not Detected'],
            ['code' => 'RD', 'desc' => 'RIF-Resistance Detected'],
            ['code' => 'RNI', 'desc' => 'RIF-Resistance Indetermine'],
        ], ['code']);
    }
}
