<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratory::upsert([
            ['code' => 'BCHM', 'desc' => 'Blood Chemistry', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'CBC', 'desc' => 'Complete Blood Count', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 1],
            ['code' => 'HEMA', 'desc' => 'Hematology', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'FCAL', 'desc' => 'Fecalysis', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 3],
            ['code' => 'CCS', 'desc' => 'Cervical Cancer Screening', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'SPTM', 'desc' => 'Direct Sputum Smear Microscopy', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 5],
            ['code' => 'URN', 'desc' => 'Urinalysis', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 2],
            ['code' => 'KOH', 'desc' => '10% Potassium Hydroxide(KOH)', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'GRMS', 'desc' => 'Gram Stain', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'WETS', 'desc' => 'Wet Smear', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'SSMR', 'desc' => 'Skin Slit Smear', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'MCRP', 'desc' => 'Microscopy', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'MRDT', 'desc' => 'Malaria RDT', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'XRAY', 'desc' => 'X-ray', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'CXRAY', 'desc' => 'Chest X-ray', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 4],
            ['code' => 'USND', 'desc' => 'Ultrasound', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'BPSY', 'desc' => 'Biopsy', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'SRLG', 'desc' => 'Serology', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'RDT', 'desc' => 'Dengue RDT', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'GXPT', 'desc' => 'MTB/RIF Exam', 'lab_active' => 0, 'konsulta_active' => 0, 'konsulta_lab_id' => null],
            ['code' => 'PSMR', 'desc' => 'Pap Smear', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 13],
            ['code' => 'OGTT', 'desc' => 'Oral Glucose Tolerance Test', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 14],
            ['code' => 'LPFL', 'desc' => 'Lipid Profile', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 6],
            ['code' => 'FBS', 'desc' => 'Fasting Blood Sugar', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 7],
            ['code' => 'CRTN', 'desc' => 'Creatinine', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 8],
            ['code' => 'ECG', 'desc' => 'Electrocardiogram (ECG)', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 9],
            ['code' => 'FOBT', 'desc' => 'Fecal Occult Blood Test', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 15],
            ['code' => 'PPD', 'desc' => 'PPD Test (Tuberculosis)', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 17],
            ['code' => 'HBA', 'desc' => 'HbA1c', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 18],
            ['code' => 'RBS', 'desc' => 'Random Blood Sugar', 'lab_active' => 1, 'konsulta_active' => 1, 'konsulta_lab_id' => 19],
        ], ['code']);
    }
}
