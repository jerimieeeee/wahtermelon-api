<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('lib_mc_locations')->delete();
        DB::table('lib_mc_locations')
      ->insert([
        ['location_code' => 'LLQ', 'location_name' => 'Left Lower Quadrant'],
        ['location_code' => 'RLQ', 'location_name' => 'Right Lower Quadrant'],
        ['location_code' => 'LUQ', 'location_name' => 'Left Upper Quadrant'],
        ['location_code' => 'RUQ', 'location_name'=> 'Right Upper Quadrant'],
        ['location_code' => 'NA', 'location_name' => 'N/A'],
      ]);

    }
}
