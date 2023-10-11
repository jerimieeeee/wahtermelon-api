<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDentalMedicalHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDentalMedicalHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDentalMedicalHistory::upsert([
            ['id' => 1, 'desc' => 'Allergies', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Hypertension/CVA', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Diabetes Mellitus', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Blood Disorders', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Cardiovascular/Heart Diseases', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Thyroid Disorders', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Hepatitis', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Malignancy', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Blood Transfusion', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Tattoo', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Others', 'sequence' => 11],
        ], ['id']);
    }
}
