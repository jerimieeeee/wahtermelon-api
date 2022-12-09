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
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN01', 'pe_desc' => 'Pallor',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN02', 'pe_desc' => 'Rashes',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN03', 'pe_desc' => 'Jaundice',              'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN04', 'pe_desc' => 'Good Skin Turgor',      'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN15', 'pe_desc' => 'Essentially normal',    'konsulta_pe_id' => '1',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN05', 'pe_desc' => 'Clubbing',              'konsulta_pe_id' => '2',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN06', 'pe_desc' => 'Cold clammy',           'konsulta_pe_id' => '3',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN07', 'pe_desc' => 'Cyanosis/mottled skin', 'konsulta_pe_id' => '4',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN08', 'pe_desc' => 'Edema/swelling',        'konsulta_pe_id' => '5',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN09', 'pe_desc' => 'Decreased mobility',    'konsulta_pe_id' => '6',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN10', 'pe_desc' => 'Pale nailbeds',         'konsulta_pe_id' => '7',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN11', 'pe_desc' => 'Poor skin turgor',      'konsulta_pe_id' => '8',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN12', 'pe_desc' => 'Weak pulses',           'konsulta_pe_id' => '10',  'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN13', 'pe_desc' => 'Others',                'konsulta_pe_id' => '99',  'konsulta_library_status' => '1', 'modules' => 'cn'],

          //HEENT
          ['category_id' => 'HEENT','pe_id' => 'HEENT01', 'pe_desc' => 'Anicteric Sclerae',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT02', 'pe_desc' => 'Pupils Briskly Reactive to Light', 'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT03', 'pe_desc' => 'Aural Discharge',                  'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT04', 'pe_desc' => 'Intact Tympanic Membrane',         'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT05', 'pe_desc' => 'Alar Flaring',                     'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT06', 'pe_desc' => 'Nasal Discharge',                  'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT07', 'pe_desc' => 'Tonsillopharyngeal Congestion',    'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT08', 'pe_desc' => 'Hypertrophic Tonsils',             'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT09', 'pe_desc' => 'Palpable Mass',                    'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT10', 'pe_desc' => 'Exudates',                         'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],

          //CHEST
          ['category_id' => 'CHEST','pe_id' => 'CHEST01', 'pe_desc' => 'Symmetrical Chest Expansion',        'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST02', 'pe_desc' => 'Clear Breathsounds',                 'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST03', 'pe_desc' => 'Retractions',                        'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST04', 'pe_desc' => 'Crackles/Rales',                     'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST05', 'pe_desc' => 'Wheezes',                            'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],

          //HEART
          ['category_id' => 'HEART','pe_id' => 'HEART01', 'pe_desc' => 'Adynamic Precordium',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART02', 'pe_desc' => 'Normal Rate Regular Rhytm',          'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEART','pe_id' => 'HEART03', 'pe_desc' => 'Heaves/Thrills',                     'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART04', 'pe_desc' => 'Murmurs',                            'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],

          //ABDOMEN
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN01', 'pe_desc' => 'Flat',                         'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN02', 'pe_desc' => 'Globular',                     'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN03', 'pe_desc' => 'Flabby',                       'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN04', 'pe_desc' => 'Muscle Guarding',              'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN05', 'pe_desc' => 'Tenderness',                   'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN06', 'pe_desc' => 'Palpable Mass',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN07', 'pe_desc' => 'Scars',                        'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN08', 'pe_desc' => 'Stretch Marks',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN09', 'pe_desc' => 'Presence of Mass',             'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN10', 'pe_desc' => 'Enlarged Liver',               'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN11', 'pe_desc' => 'Presence of Fluid Wave',       'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],

          //EXTREMITIES
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES01', 'pe_desc' => 'Gross Deformity',       'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES02', 'pe_desc' => 'Normal Gait',           'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES03', 'pe_desc' => 'Full and Equal Pulses', 'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],

          //BREAST
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST05', 'pe_desc' => 'Mass',                          'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST06', 'pe_desc' => 'Nipple Discharge',              'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST07', 'pe_desc' => 'Skin-orange peel or Dimpling',  'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST08', 'pe_desc' => 'Enlarged Axillary Lymph Nodes', 'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'ncd'],

          //EXTREMITIES
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES01', 'pe_desc' => 'Gross Deformity',       'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES02', 'pe_desc' => 'Normal Gait',           'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES03', 'pe_desc' => 'Full and Equal Pulses', 'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn'],
        ], ['category_id']);
    }
}
