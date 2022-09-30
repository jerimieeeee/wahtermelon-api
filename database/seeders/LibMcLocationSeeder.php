<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcLocation;
use Illuminate\Database\Seeder;

class LibMcLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcLocation::upsert([
            ['code' => 'LLQ', 'desc' => 'Left Lower Quadrant'],
            ['code' => 'RLQ', 'desc' => 'Right Lower Quadrant'],
            ['code' => 'LUQ', 'desc' => 'Left Upper Quadrant'],
            ['code' => 'RUQ', 'desc'=> 'Right Upper Quadrant'],
            ['code' => 'NA', 'desc' => 'N/A'],
        ], ['desc']);
    }
}
