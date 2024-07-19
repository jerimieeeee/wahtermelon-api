<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMortalityDeathPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMortalityDeathPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibMortalityDeathPlace::upsert([
            ['code' => 'FACB',     'desc' => 'Facility - Based'],
            ['code' => 'NONID',     'desc' => 'Non - Facility Based'],
        ], ['code']);
    }
}
