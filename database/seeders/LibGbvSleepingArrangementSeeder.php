<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvSleepingArrangement;
use Illuminate\Database\Seeder;

class LibGbvSleepingArrangementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvSleepingArrangement::upsert([
            ['id' => 1, 'desc' => 'At home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'On the street', 'sequence' => 2],
            ['id' => 3, 'desc' => 'In a shelter', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Other', 'sequence' => 4],
        ], ['id']);
    }
}
