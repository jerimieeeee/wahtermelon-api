<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicinePurpose;
use Illuminate\Database\Seeder;

class LibMedicinePurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMedicinePurpose::upsert([
            ['code' => '01', 'sequence' => 3, 'desc' => 'Asthma'],
            ['code' => '02', 'sequence' => 2, 'desc' => 'Acute Gastroenteritis with or no mild dehydration'],
            ['code' => '03', 'sequence' => 7, 'desc' => 'Upper Respiratory Tract Infection/Pneumonia (Minimal & Low Risk)'],
            ['code' => '04', 'sequence' => 8, 'desc' => 'Urinary Tract Infection'],
            ['code' => '05', 'sequence' => 6, 'desc' => 'Nebulization Services'],
            ['code' => '06', 'sequence' => 5, 'desc' => 'NCD'],
            ['code' => '07', 'sequence' => 4, 'desc' => 'Antibiotic'],
            ['code' => '99', 'sequence' => 9, 'desc' => 'Others'],
            ['code' => 'NA', 'sequence' => 1, 'desc' => 'Not Applicable'],
        ], ['code']);
    }
}
