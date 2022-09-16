<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('lib_mc_outcomes')->delete();
        DB::table('lib_mc_outcomes')
      ->insert([
      ['outcome_code' => 'FDU', 'outcode_name' => 'Fetal Death in Utero - Male'],
      ['outcome_code' => 'FDUF', 'outcode_name' => 'Fetal Death in Utero - Female'],
      ['outcome_code' => 'LSCSF', 'outcode_name' => 'Live baby girl LSCS'],
      ['outcome_code' => 'LSCSM', 'outcode_name' => 'Live baby boy LSCS'],
      ['outcome_code' => 'NSDF', 'outcode_name' => 'Live baby girl NSD'],
      ['outcome_code' => 'NSDM', 'outcode_name' => 'Live baby boy NSD'],
      ['outcome_code' => 'SB', 'outcode_name' => 'Stillbirth - Male'],
      ['outcome_code' => 'SBF', 'outcode_name' => 'Stillbirth - Female'],
      ['outcome_code' => 'TWIN', 'outcode_name' => 'Twin']
      ]);

    }
}
