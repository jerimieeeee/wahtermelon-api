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
            ['id' => 1, 'desc' => 'Allergies',                      'column_name' => 'allergies_flag',          'sequence' => 1],
            ['id' => 2, 'desc' => 'Hypertension/CVA',               'column_name' => 'hypertension_flag',       'sequence' => 2],
            ['id' => 3, 'desc' => 'Diabetes Mellitus',              'column_name' => 'diabetes_flag',           'sequence' => 3],
            ['id' => 4, 'desc' => 'Blood Disorders',                'column_name' => 'blood_disorder_flag',     'sequence' => 4],
            ['id' => 5, 'desc' => 'Cardiovascular/Heart Diseases',  'column_name' => 'heart_disease_flag',      'sequence' => 5],
            ['id' => 6, 'desc' => 'Thyroid Disorders',              'column_name' => 'thyroid_flag',            'sequence' => 6],
            ['id' => 7, 'desc' => 'Hepatitis',                      'column_name' => 'hepatitis_flag',          'sequence' => 7],
            ['id' => 8, 'desc' => 'Malignancy',                     'column_name' => 'malignancy_flag',         'sequence' => 8],
            ['id' => 9, 'desc' => 'Blood Transfusion',              'column_name' => 'blood_transfusion_flag',  'sequence' => 9],
            ['id' => 10, 'desc' => 'Tattoo',                        'column_name' => 'tattoo_flag',             'sequence' => 10],
            ['id' => 11, 'desc' => 'Others',                        'column_name' => 'medical_others_flag',             'sequence' => 11],
        ], ['id']);
    }
}
