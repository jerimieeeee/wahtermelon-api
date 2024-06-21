<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDentalToothService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDentalToothServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDentalToothService::upsert([
            ['code' => 'PF',    'desc' => 'Permanent Filling',          'sequence' => 1],
            ['code' => 'PFS',   'desc' => 'Pit and Fissure Sealant',    'sequence' => 2],
            ['code' => 'TF',    'desc' => 'Temporary Filling',          'sequence' => 3],
            ['code' => 'X',     'desc' => 'Extraction',                 'sequence' => 4],
            ['code' => 'O',     'desc' => 'Others',                     'sequence' => 5]
        ], ['code']);
    }
}
