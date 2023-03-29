<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbSymptoms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbSymptomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbSymptoms::upsert([
            ['code' => 'BCP',   'desc' => 'Back/Chest Pain'],
            ['code' => 'C',     'desc' => 'Cough'],
            ['code' => 'DAR',   'desc' => 'Dyspnea at rest'],
            ['code' => 'DOE',   'desc' => 'Dyspnea on exertion'],
            ['code' => 'F',     'desc' => 'Fever'],
            ['code' => 'H',     'desc' => 'Hemoptysis'],
            ['code' => 'NS',    'desc' => 'Night Sweats'],
            ['code' => 'PE',    'desc' => 'Pedal Edema'],
            ['code' => 'WL',    'desc' => 'Weight Loss']
        ], ['code']);
    }
}
