<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEnvironmentalWaterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEnvironmentalWaterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEnvironmentalWaterType::upsert([
            ['code' => '1',           'desc' => 'LEVEL 1 - Point Source',                   'sequence' => '1'],
            ['code' => '2',           'desc' => 'LEVEL 2 - Communal Faucet',                'sequence' => '2'],
            ['code' => '3',           'desc' => 'LEVEL 3 -  Individual Connection',         'sequence' => '3'],
            ['code' => '4',           'desc' => 'Others',                                   'sequence' => '4'],
        ], ['code']);
    }
}
