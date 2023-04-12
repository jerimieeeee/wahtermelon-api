<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbTreatmentRegimen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbTreatmentRegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbTreatmentRegimen::upsert([
            ['code' => 'CATI',  'desc' => 'Regimen I'],
            ['code' => 'CATII', 'desc' => 'Regimen II']
        ], ['code']);
    }
}
