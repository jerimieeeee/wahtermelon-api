<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryMtbResult;
use Illuminate\Database\Seeder;

class LibLaboratoryMtbResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryMtbResult::upsert([
            ['code' => 'NDTC', 'desc' => 'Not Detected'],
            ['code' => 'D', 'desc' => 'Detected'],
            ['code' => 'INV', 'desc' => 'Invalid/No Result/Error'],
            ['code' => 'ND', 'desc' => 'Not Done'],
        ], ['code']);
    }
}
