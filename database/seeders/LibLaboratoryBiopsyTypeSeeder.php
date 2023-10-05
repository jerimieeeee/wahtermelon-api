<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryBiopsyType;
use Illuminate\Database\Seeder;

class LibLaboratoryBiopsyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryBiopsyType::upsert([
            ['code' => 'NDL', 'desc' => 'Needle'],
            ['code' => 'CTG', 'desc' => 'CT-Guided'],
            ['code' => 'ULG', 'desc' => 'Ultrasound-Guided'],
            ['code' => 'BONE', 'desc' => 'Bone'],
            ['code' => 'BONEMRW', 'desc' => 'Bone Marrow'],
        ], ['code']);
    }
}
