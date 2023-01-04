<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryChestxrayObservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryChestxrayObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryChestxrayObservation::upsert([
            ['code' => '1', 'desc' => 'INFILTRATES'],
            ['code' => '2', 'desc' => 'CALCIFICATION'],
            ['code' => '3', 'desc' => 'CONSOLIDATION'],
            ['code' => '4', 'desc' => 'CAVITY'],
            ['code' => '5', 'desc' => 'DENSITIES'],
            ['code' => '6', 'desc' => 'PLEURAL EFFUSION'],
            ['code' => '7', 'desc' => 'PNEUMOTHORAX'],
            ['code' => '8', 'desc' => 'BLEB'],
            ['code' => '9', 'desc' => 'CARDIOMEGALY'],
            ['code' => '10', 'desc' => 'THICKENING'],
            ['code' => '11', 'desc' => 'HYPERAERATION/ EMPHYSEMATOUS CHANGES'],
            ['code' => '12', 'desc' => 'MASS'],
            ['code' => '99', 'desc' => 'OTHERS'],
        ], ['code']);
    }
}
