<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibResidenceClassification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibResidenceClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibResidenceClassification::upsert([
            ['code' => '01', 'desc' => 'Informal Settlers'],
            ['code' => '02', 'desc' => 'Resettlement'],
        ], ['code']);
    }
}
