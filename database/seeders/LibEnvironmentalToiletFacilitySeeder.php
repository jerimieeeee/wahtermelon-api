<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEnvironmentalToiletFacility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEnvironmentalToiletFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEnvironmentalToiletFacility::upsert([
            ['code' => '1',           'desc' => 'Pour/flush type connected to septic tank',                                             'category' => 'Sanitary',           'sequence' => '1'],
            ['code' => '2',           'desc' => 'Pour/flush toilet connected to septic tank and to sewerage system',                    'category' => 'Sanitary',           'sequence' => '2'],
            ['code' => '3',           'desc' => 'Ventilated Pit (VIT) Latrine or composting toilet',                                    'category' => 'Sanitary',           'sequence' => '3'],
            ['code' => '4',           'desc' => 'Water sealed toilet with other containment (pit/drum/others) but for improvement',     'category' => 'Sanitary',           'sequence' => '4'],
            ['code' => '5',           'desc' => 'Water sealed connected to open drain',                                                 'category' => 'Unsanitary',         'sequence' => '5'],
            ['code' => '6',           'desc' => 'Overhung Latrine',                                                                     'category' => 'Unsanitary',         'sequence' => '6'],
            ['code' => '7',           'desc' => 'Open Pit Latrine',                                                                     'category' => 'Unsanitary',         'sequence' => '7'],
            ['code' => '8',           'desc' => 'Without Toilet',                                                                       'category' => 'Unsanitary',         'sequence' => '8'],
        ], ['code']);
    }
}
