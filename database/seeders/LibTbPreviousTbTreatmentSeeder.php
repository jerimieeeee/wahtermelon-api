<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbPreviousTbTreatment;
use Illuminate\Database\Seeder;

class LibTbPreviousTbTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbPreviousTbTreatment::upsert([
            ['code' => 'F', 'desc' => 'First line drugs only'],
            ['code' => 'FS', 'desc' => 'First and second-line drugs'],
            ['code' => 'N', 'desc' => 'New'],
            ['code' => 'NA', 'desc' => 'Not Applicable'],
        ], ['code']);
    }
}
