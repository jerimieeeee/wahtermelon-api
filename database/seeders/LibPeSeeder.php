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
<<<<<<< HEAD
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN01', 'pe_desc' => 'Pallor',                'konsulta_pe_id' => '',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'SKIN', 'pe_id' => 'SKIN02', 'pe_desc' => 'Rashes/Petechiae',      'konsulta_pe_id' => '9',   'konsulta_library_status' => '1', 'modules' => 'cn,ncd'],
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
=======
          ['category_id' => 'SKIN','pe_id' => 'SKIN01', 'pe_desc' => 'Pallor'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN02', 'pe_desc' => 'Rashes'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN03', 'pe_desc' => 'Jaundice'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN04', 'pe_desc' => 'Good Skin Turgor'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN15', 'pe_desc' => 'Essentially normal'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN05', 'pe_desc' => 'Clubbing'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN06', 'pe_desc' => 'Cold clammy'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN07', 'pe_desc' => 'Cyanosis/mottled skin'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN08', 'pe_desc' => 'Edema/swelling'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN09', 'pe_desc' => 'Decreased mobility'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN10', 'pe_desc' => 'Pale nailbeds'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN11', 'pe_desc' => 'Poor skin turgor'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN12', 'pe_desc' => 'Weak pulses'],
          ['category_id' => 'SKIN','pe_id' => 'SKIN13', 'pe_desc' => 'Others'],
>>>>>>> 32bac57eea9a790fe2245978e5f573f3407990bf

          //HEENT
          ['category_id' => 'HEENT','pe_id' => 'HEENT01', 'pe_desc' => 'Anicteric Sclerae',                'konsulta_pe_id' => '1',     'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT02', 'pe_desc' => 'Pupils Briskly Reactive to Light', 'konsulta_pe_id' => '3',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT03', 'pe_desc' => 'Aural Discharge',                  'konsulta_pe_id' => '8',     'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT04', 'pe_desc' => 'Intact Tympanic Membrane',         'konsulta_pe_id' => '2',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT05', 'pe_desc' => 'Alar Flaring',                     'konsulta_pe_id' => '6',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT06', 'pe_desc' => 'Nasal Discharge',                  'konsulta_pe_id' => '7',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT07', 'pe_desc' => 'Tonsillopharyngeal Congestion',    'konsulta_pe_id' => '4',     'konsulta_library_status' => '0', 'modules' => 'cn,'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT08', 'pe_desc' => 'Hypertrophic Tonsils',             'konsulta_pe_id' => '5',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT09', 'pe_desc' => 'Palpable Mass',                    'konsulta_pe_id' => '9',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT10', 'pe_desc' => 'Exudates',                         'konsulta_pe_id' => '10',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT11', 'pe_desc' => 'Essentially Normal',               'konsulta_pe_id' => '11',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT12', 'pe_desc' => 'Abnormal pupillary reaction',      'konsulta_pe_id' => '12',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT13', 'pe_desc' => 'Cervical lympadenopathy',          'konsulta_pe_id' => '13',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT14', 'pe_desc' => 'Dry mucous membrane',              'konsulta_pe_id' => '14',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT15', 'pe_desc' => 'Icteric sclerae',                  'konsulta_pe_id' => '15',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT16', 'pe_desc' => 'Pale conjunctivae',                'konsulta_pe_id' => '16',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT17', 'pe_desc' => 'Sunken eyeballs',                  'konsulta_pe_id' => '17',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT18', 'pe_desc' => 'Sunken fontanelle',                'konsulta_pe_id' => '18',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEENT','pe_id' => 'HEENT19', 'pe_desc' => 'Others',                           'konsulta_pe_id' => '99',    'konsulta_library_status' => '1', 'modules' => 'cn'],

          //CHEST
          ['category_id' => 'CHEST','pe_id' => 'CHEST01', 'pe_desc' => 'Symmetrical Chest Expansion',        'konsulta_pe_id' => '1',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST02', 'pe_desc' => 'Clear Breathsounds',                 'konsulta_pe_id' => '2',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST03', 'pe_desc' => 'Retractions',                        'konsulta_pe_id' => '3',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST04', 'pe_desc' => 'Crackles/Rales',                     'konsulta_pe_id' => '4',    'konsulta_library_status' => '1', 'modules' => 'cn,ncd'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST05', 'pe_desc' => 'Wheezes',                            'konsulta_pe_id' => '5',    'konsulta_library_status' => '1', 'modules' => 'cn,ncd'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST06', 'pe_desc' => 'Essentially normal',                 'konsulta_pe_id' => '6',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST07', 'pe_desc' => 'Asymmetrical chest expansion',       'konsulta_pe_id' => '7',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST08', 'pe_desc' => 'Decreased breath sounds',            'konsulta_pe_id' => '8',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST09', 'pe_desc' => 'Enlarge Axillary Lymph Nodes',       'konsulta_pe_id' => '9',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'CHEST','pe_id' => 'CHEST10', 'pe_desc' => 'Others',                             'konsulta_pe_id' => '99',   'konsulta_library_status' => '1', 'modules' => 'cn'],

          //HEART
          ['category_id' => 'HEART','pe_id' => 'HEART01', 'pe_desc' => 'Adynamic Precordium',                'konsulta_pe_id' => '1',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART02', 'pe_desc' => 'Normal Rate Regular Rhytm',          'konsulta_pe_id' => '2',    'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEART','pe_id' => 'HEART03', 'pe_desc' => 'Heaves/Thrills',                     'konsulta_pe_id' => '3',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART04', 'pe_desc' => 'Murmurs',                            'konsulta_pe_id' => '4',    'konsulta_library_status' => '1', 'modules' => 'cn,ncd'],
          ['category_id' => 'HEART','pe_id' => 'HEART05', 'pe_desc' => 'Essentially normal',                 'konsulta_pe_id' => '5',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART06', 'pe_desc' => 'Displaced apex beat',                'konsulta_pe_id' => '6',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART07', 'pe_desc' => 'Irregular rhythm',                   'konsulta_pe_id' => '7',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART08', 'pe_desc' => 'Muffled heart sounds',               'konsulta_pe_id' => '8',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART03', 'pe_desc' => 'Pericardial bulge',                  'konsulta_pe_id' => '9',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'HEART','pe_id' => 'HEART03', 'pe_desc' => 'Others',                             'konsulta_pe_id' => '99',   'konsulta_library_status' => '1', 'modules' => 'cn'],

          //ABDOMEN
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN01', 'pe_desc' => 'Flat',                         'konsulta_pe_id' => '1',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN03', 'pe_desc' => 'Flabby',                       'konsulta_pe_id' => '2',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN02', 'pe_desc' => 'Globullar',                    'konsulta_pe_id' => '3',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN04', 'pe_desc' => 'Muscle Guarding',              'konsulta_pe_id' => '4',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN05', 'pe_desc' => 'Tenderness',                   'konsulta_pe_id' => '5',     'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN06', 'pe_desc' => 'Palpable Mass',                'konsulta_pe_id' => '6',     'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN07', 'pe_desc' => 'Scars',                        'konsulta_pe_id' => '',      'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN08', 'pe_desc' => 'Stretch Marks',                'konsulta_pe_id' => '',      'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN09', 'pe_desc' => 'Presence of Mass',             'konsulta_pe_id' => '',      'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN10', 'pe_desc' => 'Enlarged Liver',               'konsulta_pe_id' => '',      'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN11', 'pe_desc' => 'Presence of Fluid Wave',       'konsulta_pe_id' => '',      'konsulta_library_status' => '0', 'modules' => 'cn,ncd'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN12', 'pe_desc' => 'Essentially normal',           'konsulta_pe_id' => '7',     'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN13', 'pe_desc' => 'Abdominal rigidity',           'konsulta_pe_id' => '8',     'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN14', 'pe_desc' => 'Abdominal tenderness',         'konsulta_pe_id' => '9',     'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN15', 'pe_desc' => 'Hyperactive bowel sounds',     'konsulta_pe_id' => '10',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN16', 'pe_desc' => 'Palpable mass(es)',            'konsulta_pe_id' => '11',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN17', 'pe_desc' => 'Tympanitic/dull abdomen',      'konsulta_pe_id' => '12',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN18', 'pe_desc' => 'Uterine contraction',          'konsulta_pe_id' => '13',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'ABDOMEN', 'pe_id' => 'ABDOMEN19', 'pe_desc' => 'Others',                       'konsulta_pe_id' => '99',    'konsulta_library_status' => '1', 'modules' => 'cn'],

          //EXTREMITIES
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES01', 'pe_desc' => 'Gross Deformity',       'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES02', 'pe_desc' => 'Normal Gait',           'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'cn'],
          ['category_id' => 'EXTREMITIES','pe_id' => 'EXTREMITIES03', 'pe_desc' => 'Full and Equal Pulses', 'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'cn'],

          //BREAST
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST05', 'pe_desc' => 'Mass',                          'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST06', 'pe_desc' => 'Nipple Discharge',              'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST07', 'pe_desc' => 'Skin-orange peel or Dimpling',  'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'BREAST',     'pe_id' => 'BREAST08', 'pe_desc' => 'Enlarged Axillary Lymph Nodes', 'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],

          //PELVIC
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC01', 'pe_desc' => 'Vulva: Redness (inflammation)',       'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC02', 'pe_desc' => 'Tenderness',                          'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC03', 'pe_desc' => 'Ulcers',                              'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC04', 'pe_desc' => 'Blisters',                            'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC05', 'pe_desc' => 'Warts',                               'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC06', 'pe_desc' => 'Cyst',                                'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC07', 'pe_desc' => 'Skin Tags',                           'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],
          ['category_id' => 'PELVIC','pe_id' => 'PELVIC08', 'pe_desc' => 'Other Mass',                          'konsulta_pe_id' => '',    'konsulta_library_status' => '', 'modules' => 'ncd'],

          //NEURO
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO01',   'pe_desc' => 'Developmental delay',                'konsulta_pe_id' => '1',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO02',   'pe_desc' => 'Seizures',                           'konsulta_pe_id' => '2',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO03',   'pe_desc' => 'Normal',                             'konsulta_pe_id' => '3',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO04',   'pe_desc' => 'Motor Deficit',                      'konsulta_pe_id' => '4',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO05',   'pe_desc' => 'Sensory Deficit',                    'konsulta_pe_id' => '5',    'konsulta_library_status' => '0', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO06',   'pe_desc' => 'Essentially normal',                 'konsulta_pe_id' => '6',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO07',   'pe_desc' => 'Abnormal gait',                      'konsulta_pe_id' => '7',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO08',   'pe_desc' => 'Abnormal position sense',            'konsulta_pe_id' => '8',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO09',   'pe_desc' => 'Abnormal sensation',                 'konsulta_pe_id' => '9',    'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO10',  'pe_desc' => 'Abnormal reflex(es)',                'konsulta_pe_id' => '10',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO11',  'pe_desc' => 'Poor/altered memory',                'konsulta_pe_id' => '11',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO12',  'pe_desc' => 'Poor muscle tone/strength',          'konsulta_pe_id' => '12',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO13',  'pe_desc' => 'Poor coordination',                  'konsulta_pe_id' => '13',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'NEURO', 'pe_id' => 'NEURO14',  'pe_desc' => 'Others',                             'konsulta_pe_id' => '14',   'konsulta_library_status' => '1', 'modules' => 'cn'],

          //DIGITAL RECTAL
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL01',  'pe_desc' => 'Essentially normal',                'konsulta_pe_id' => '1',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL02',  'pe_desc' => 'Enlarge Prospate',                  'konsulta_pe_id' => '2',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL03',  'pe_desc' => 'Mass',                              'konsulta_pe_id' => '3',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL04',  'pe_desc' => 'Hemorrhoids',                       'konsulta_pe_id' => '4',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL05',  'pe_desc' => 'Pus',                               'konsulta_pe_id' => '5',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL06',  'pe_desc' => 'Not Applicable',                    'konsulta_pe_id' => '0',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'RECTAL', 'pe_id' => 'RECTAL07',  'pe_desc' => 'Others',                            'konsulta_pe_id' => '99',  'konsulta_library_status' => '1', 'modules' => 'cn'],

          //GENITOURINARY
          ['category_id' => 'GENITOURINARY', 'pe_id' => 'GENITOURINARY01',  'pe_desc' => 'Essentially normal',                'konsulta_pe_id' => '1',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'GENITOURINARY', 'pe_id' => 'GENITOURINARY02',  'pe_desc' => 'Blood stained in exam finger',      'konsulta_pe_id' => '2',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'GENITOURINARY', 'pe_id' => 'GENITOURINARY03',  'pe_desc' => 'Cervical dilatation',               'konsulta_pe_id' => '3',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'GENITOURINARY', 'pe_id' => 'GENITOURINARY04',  'pe_desc' => 'Presence of abnormal discharge',    'konsulta_pe_id' => '4',   'konsulta_library_status' => '1', 'modules' => 'cn'],
          ['category_id' => 'GENITOURINARY', 'pe_id' => 'GENITOURINARY05',  'pe_desc' => 'Others',                            'konsulta_pe_id' => '99',  'konsulta_library_status' => '1', 'modules' => 'cn'],

        ], ['category_id']);
    }
}
