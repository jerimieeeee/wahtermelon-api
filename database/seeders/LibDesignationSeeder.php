<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDesignation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibDesignation::upsert([
            ['code' => 'BHW', 'desc' => 'Barangay Health Worker'],
            ['code' => 'DENTALAIDE', 'desc' => 'Dental Aide'],
            ['code' => 'DENTIST', 'desc' => 'Dentist'],
            ['code' => 'LABAIDE', 'desc' => 'Lab Aide'],
            ['code' => 'MD', 'desc' => 'Physician'],
            ['code' => 'MEDTECH', 'desc' => 'Medical Technologist'],
            ['code' => 'MWIFE', 'desc' => 'Midwife'],
            ['code' => 'RN', 'desc' => 'Nurse'],
            ['code' => 'RSI', 'desc' => 'Sanitation Inspector'],
            ['code' => 'NDP', 'desc' => 'Nurse Deployment Program'],
            ['code' => 'RHMPP', 'desc' => 'Rural Health Midwives Placement Program'],
            ['code' => 'PHA', 'desc' => 'Public Health Assistant'],
            ['code' => 'ENC', 'desc' => 'Encoder'],
            ['code' => 'CLK', 'desc' => 'Clerk'],
            ['code' => 'PHAR', 'desc' => 'Pharmacist'],
            ['code' => 'NA', 'desc' => 'Nursing Attendant'],
            ['code' => 'RADTECH', 'desc' => 'Radiologist'],
            ['code' => 'NUT', 'desc' => 'Nutritionists/Dietitians'],
            ['code' => 'RSE', 'desc' => 'Sanitary Engineers']
        ], ['code']);
    }
}
