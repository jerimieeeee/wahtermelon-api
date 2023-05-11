<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPlacementLocation;
use Illuminate\Database\Seeder;

class LibGbvPlacementLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPlacementLocation::upsert([
            ['id' => 1, 'desc' => 'Home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Relative', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Shelter', 'sequence' => 3],
            ['id' => 4, 'desc' => 'PGH', 'sequence' => 4],
        ], ['id']);
    }
}
