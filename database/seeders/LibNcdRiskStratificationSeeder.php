<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRiskStratification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRiskStratificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRiskStratification::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRiskStratification::upsert([
          ['risk_level' => '<10%',         'risk_color' => '#009900', 'konsulta_risk_stratifcation_id' => 'A'],
          ['risk_level' => '10% to < 20%', 'risk_color' => '#CCFF00', 'konsulta_risk_stratifcation_id' => 'B'],
          ['risk_level' => '20% to < 30%', 'risk_color' => '#FF9900', 'konsulta_risk_stratifcation_id' => 'C'],
          ['risk_level' => '30% to < 40%', 'risk_color' => '#CC0000', 'konsulta_risk_stratifcation_id' => 'D'],
          ['risk_level' => '≥ 40%',        'risk_color' => '#990000', 'konsulta_risk_stratifcation_id' => 'E'],
        ], ['id']);
    }
}
