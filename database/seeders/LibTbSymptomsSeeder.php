<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbSymptoms;
use Illuminate\Database\Seeder;

class LibTbSymptomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbSymptoms::upsert([
            ['code' => 'bcpain',   'desc' => 'Back/Chest Pain'],
            ['code' => 'cough',     'desc' => 'Cough'],
            ['code' => 'drest',   'desc' => 'Dyspnea at rest'],
            ['code' => 'dexertion',   'desc' => 'Dyspnea on exertion'],
            ['code' => 'fever',     'desc' => 'Fever'],
            ['code' => 'hemoptysis',     'desc' => 'Hemoptysis'],
            ['code' => 'nsweats',    'desc' => 'Night Sweats'],
            ['code' => 'pedema',    'desc' => 'Pedal Edema'],
            ['code' => 'wloss',    'desc' => 'Weight Loss'],
        ], ['code']);
    }
}
