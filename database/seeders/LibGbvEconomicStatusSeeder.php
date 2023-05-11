<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvEconomicStatus;
use Illuminate\Database\Seeder;

class LibGbvEconomicStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvEconomicStatus::upsert([
            ['id' => 1, 'desc' => 'Low', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Middle', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Upper', 'sequence' => 3],
        ], ['id']);
    }
}
