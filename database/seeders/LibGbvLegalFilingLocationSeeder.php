<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvLegalFilingLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvLegalFilingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvLegalFilingLocation::upsert([
            ['id' => 1, 'desc' => 'NBI', 'sequence' => 1],
            ['id' => 2, 'desc' => 'CRC', 'sequence' => 2],
            ['id' => 3, 'desc' => 'PNP', 'sequence' => 3],
        ], ['id']);
    }
}
