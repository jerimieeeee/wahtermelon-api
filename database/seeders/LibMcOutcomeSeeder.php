<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcOutcome;
use Illuminate\Database\Seeder;

class LibMcOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcOutcome::upsert([
            ['code' => 'FDU', 'desc' => 'Fetal Death in Utero - Male'],
            ['code' => 'FDUF', 'desc' => 'Fetal Death in Utero - Female'],
            ['code' => 'LSCSF', 'desc' => 'Live baby girl LSCS'],
            ['code' => 'LSCSM', 'desc' => 'Live baby boy LSCS'],
            ['code' => 'NSDF', 'desc' => 'Live baby girl NSD'],
            ['code' => 'NSDM', 'desc' => 'Live baby boy NSD'],
            ['code' => 'SB', 'desc' => 'Stillbirth - Male'],
            ['code' => 'SBF', 'desc' => 'Stillbirth - Female'],
            ['code' => 'TWIN', 'desc' => 'Twin'],
        ], ['desc']);
    }
}
