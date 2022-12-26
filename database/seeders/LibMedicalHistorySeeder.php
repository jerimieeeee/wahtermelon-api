<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicalHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibMedicalHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibMedicalHistory::truncate();
        Schema::enableForeignKeyConstraints();

        LibMedicalHistory::upsert([
            ['history_desc' => 'Allergy',                       'konsulta_history_id' => '001', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Asthma',                        'konsulta_history_id' => '002', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Cancer',                        'konsulta_history_id' => '003', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Cerebrovascular Disease',       'konsulta_history_id' => '004', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Coronary Artery Disease',       'konsulta_history_id' => '005', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Diabetes Mellitus',             'konsulta_history_id' => '006', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Emphysema',                     'konsulta_history_id' => '007', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Epilepsy/Seizure Disorder',     'konsulta_history_id' => '008', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Hepatitis',                     'konsulta_history_id' => '009', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Hyperlipidemia',                'konsulta_history_id' => '010', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Hypertension',                  'konsulta_history_id' => '011', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Peptic Ulcer Disease',          'konsulta_history_id' => '012', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Pneumonia',                     'konsulta_history_id' => '013', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Thyroid Disease',               'konsulta_history_id' => '014', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Pulmonary Tuberculosis',        'konsulta_history_id' => '015', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Extrapulmonary Tuberculosis',   'konsulta_history_id' => '016', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Urinary Tract Infection',       'konsulta_history_id' => '017', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Mental Illness',                'konsulta_history_id' => '018', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'Others',                        'konsulta_history_id' => '998', 'konsulta_library_status' => '1', ],
            ['history_desc' => 'None',                          'konsulta_history_id' => '999', 'konsulta_library_status' => '1', ],
        ], ['id']);
    }
}
