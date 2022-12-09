<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibPeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPe::upsert([
          //SKIN  
          ['category_id' => 'SKIN','pe_id' => 'SKIN01', 'pe_desc' => 'Pallor',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN02', 'pe_desc' => 'Rashes',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN03', 'pe_desc' => 'Jaundice',              'konsulta_pe_id' => '',    'konsulta_library_status' => '0'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN04', 'pe_desc' => 'Good Skin Turgor',      'konsulta_pe_id' => '',    'konsulta_library_status' => '0'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN15', 'pe_desc' => 'Essentially normal',    'konsulta_pe_id' => '1',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN05', 'pe_desc' => 'Clubbing',              'konsulta_pe_id' => '2',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN06', 'pe_desc' => 'Cold clammy',           'konsulta_pe_id' => '3',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN07', 'pe_desc' => 'Cyanosis/mottled skin', 'konsulta_pe_id' => '4',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN08', 'pe_desc' => 'Edema/swelling',        'konsulta_pe_id' => '5',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN09', 'pe_desc' => 'Decreased mobility',    'konsulta_pe_id' => '6',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN10', 'pe_desc' => 'Pale nailbeds',         'konsulta_pe_id' => '7',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN11', 'pe_desc' => 'Poor skin turgor',      'konsulta_pe_id' => '8',   'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN12', 'pe_desc' => 'Weak pulses',           'konsulta_pe_id' => '10',  'konsulta_library_status' => '1'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN13', 'pe_desc' => 'Others',                'konsulta_pe_id' => '99',  'konsulta_library_status' => '1'],

          //HEENT
          ['category_id' => 'HEENT','pe_id' => 'HEENT01', 'pe_desc' => 'Anicteric Sclerae'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT02', 'pe_desc' => 'Pupils Briskly Reactive to Light'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT03', 'pe_desc' => 'Aural Discharge'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT04', 'pe_desc' => 'Intact Tympanic Membrane'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT05', 'pe_desc' => 'Alar Flaring'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT06', 'pe_desc' => 'Nasal Discharge'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT07', 'pe_desc' => 'Tonsillopharyngeal Congestion'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT08', 'pe_desc' => 'Hypertrophic Tonsils'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT09', 'pe_desc' => 'Palpable Mass'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT10', 'pe_desc' => 'Exudates'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST01', 'pe_desc' => 'Symmetrical Chest Expansion'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST02', 'pe_desc' => 'Clear Breathsounds'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST03', 'pe_desc' => 'Retractions'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST04', 'pe_desc' => 'Crackles/Rales'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST05', 'pe_desc' => 'Wheezes'],
          ['category_id' => 'HEART','pe_id' => 'HEART01', 'pe_desc' => 'Adynamic Precordium'],
          ['category_id' => 'HEART','pe_id' => 'HEART02', 'pe_desc' => 'Normal Rate Regular Rhytm'],
          ['category_id' => 'HEART','pe_id' => 'HEART03', 'pe_desc' => 'Heaves/Thrills'],
          ['category_id' => 'HEART','pe_id' => 'HEART04', 'pe_desc' => 'Murmurs'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN01', 'pe_desc' => 'Flat'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN02', 'pe_desc' => 'Globular'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN03', 'pe_desc' => 'Flabby'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN04', 'pe_desc' => 'Muscle Guarding'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN05', 'pe_desc' => 'Tenderness'],
          ['category_id' => 'ABDOMEN','pe_id' => 'ABDOMEN06', 'pe_desc' => 'Palpable Mass'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES01', 'pe_desc' => 'Gross Deformity'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES02', 'pe_desc' => 'Normal Gait'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES03', 'pe_desc' => 'Full and Equal Pulses']
        ], ['category_id']);
    }
}
