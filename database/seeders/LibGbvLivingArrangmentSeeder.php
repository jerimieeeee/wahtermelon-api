<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvLivingArrangment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvLivingArrangmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvLivingArrangment::upsert([
            ['id' => 1, 'desc' => 'Street Child', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Street Family', 'sequence' => 2],
            ['id' => 3, 'desc' => 'NGO Shelter', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Gov\'t Agency', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Unknown', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Single Parent', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Immediate Family', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Extended Family', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Relatives', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Non-relatives', 'sequence' => 10]
        ], ['id']);
    }
}
