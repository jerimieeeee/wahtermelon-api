<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryUltrasoundType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryUltrasoundTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryUltrasoundType::upsert([
            ['code' => 'ABD', 'desc' => 'Abdomen'],
            ['code' => 'PELV', 'desc' => 'Pelvic'],
            ['code' => 'SFT', 'desc' => 'Soft Tissue'],
            ['code' => 'CHX', 'desc' => 'Chest'],
            ['code' => 'BRT', 'desc' => 'Breast'],
        ], ['code']);
    }
}
