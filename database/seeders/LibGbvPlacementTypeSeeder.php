<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPlacementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvPlacementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPlacementType::upsert([
            ['id' => 1, 'desc' => 'Temporary', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Long Term', 'sequence' => 2],
        ], ['id']);
    }
}
