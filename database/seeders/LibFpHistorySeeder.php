<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpHistory;
use Illuminate\Database\Seeder;

class LibFpHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFpHistory::upsert([
            ['code' => 'GALL',          'desc' => 'History of gallbladder disease',                         'category' => 'ABD',        'sequence' => '1'],
            ['code' => 'LIVER',         'desc' => 'History of liver disease',                               'category' => 'ABD',        'sequence' => '2'],
            ['code' => 'MASSABD',       'desc' => 'Mass in the abdomen',                                    'category' => 'ABD',        'sequence' => '3'],
            ['code' => 'ALLERGY',       'desc' => 'Allergies',                                              'category' => 'ANY',        'sequence' => '4'],
            ['code' => 'ANEMIA',        'desc' => 'Anemia',                                                 'category' => 'ANY',        'sequence' => '5'],
            ['code' => 'BLEEDING',      'desc' => 'Bleeding tendencies (nose, gums, etc.)',                 'category' => 'ANY',        'sequence' => '6'],
            ['code' => 'DIABETES',      'desc' => 'Diabetes',                                               'category' => 'ANY',        'sequence' => '7'],
            ['code' => 'DRUGINTAKE',    'desc' => 'Drug intake (anti-TB, anti-diabetic, anticonvulsant)',   'category' => 'ANY',        'sequence' => '8'],
            ['code' => 'ECTPREG',       'desc' => 'Ectopic pregnancy',                                      'category' => 'ANY',        'sequence' => '9'],
            ['code' => 'STD',           'desc' => 'STD',                                                    'category' => 'ANY',        'sequence' => '10'],
            ['code' => 'HMOLE',         'desc' => 'Hydatidiform mole (w/in the last 12 mos.)',              'category' => 'ANY',        'sequence' => '11'],
            ['code' => 'SMOKING',       'desc' => 'Smoking',                                                'category' => 'ANY',        'sequence' => '12'],
            ['code' => 'MPARTNERS',     'desc' => 'Multiple partners',                                      'category' => 'ANY',        'sequence' => '13'],

            ['code' => 'BRSTMASS',      'desc' => 'Breast/axillary masses',                                                             'category' => 'CXHRT',    'sequence' => '14'],
            ['code' => 'CVAHARHD',      'desc' => 'Family history of CVA (strokes), hypertension, asthma, rheumatic heart disease',     'category' => 'CXHRT',    'sequence' => '15'],
            ['code' => 'CXPAIN',        'desc' => 'Severe chest pain',                                                                  'category' => 'CXHRT',    'sequence' => '16'],
            ['code' => 'DIAS90',        'desc' => 'Diastolic of 90 & above',                                                            'category' => 'CXHRT',    'sequence' => '17'],
            ['code' => 'SYS140',        'desc' => 'Systolic of 140 & above',                                                            'category' => 'CXHRT',    'sequence' => '18'],
            ['code' => 'FATIGUE',       'desc' => 'Shortness of breath and easy fatiguability',                                         'category' => 'CXHRT',    'sequence' => '19'],
            ['code' => 'NIPBLOOD',      'desc' => 'Nipple discharges (blood)',                                                          'category' => 'CXHRT',    'sequence' => '20'],
            ['code' => 'NIPPUS',        'desc' => 'Nipple discharges (pus)',                                                            'category' => 'CXHRT',    'sequence' => '21'],

            ['code' => 'VARICOSE',      'desc' => 'Severe varicosities',                                                                'category' => 'EXT',      'sequence' => '22'],
            ['code' => 'LEGPAIN',       'desc' => 'Swelling or severe pain in the legs not related to injuries',                        'category' => 'EXT',      'sequence' => '23'],

            ['code' => 'POSTBLEED',     'desc' => 'Postcoital bleeding',                                                                'category' => 'GEN',      'sequence' => '24'],
            ['code' => 'INTERBLEED',    'desc' => 'Intermenstrual bleeding',                                                            'category' => 'GEN',      'sequence' => '25'],
            ['code' => 'UTERUS',        'desc' => 'Mass in the uterus',                                                                 'category' => 'GEN',      'sequence' => '26'],
            ['code' => 'VAGDISCH',      'desc' => 'Vaginal discharge',                                                                  'category' => 'GEN',      'sequence' => '27'],

            ['code' => 'HEADACHE',      'desc' => 'Severe headache/dizziness',                                                          'category' => 'HEENT',    'sequence' => '28'],
            ['code' => 'ETHY',          'desc' => 'Enlarged thyroid',                                                                   'category' => 'HEENT',    'sequence' => '29'],
            ['code' => 'EPILEPSY',      'desc' => 'Epilepsy/Convulsion/Seizure',                                                        'category' => 'HEENT',    'sequence' => '30'],
            ['code' => 'VISION',        'desc' => 'Visual disturbance/blurring of visione',                                             'category' => 'HEENT',    'sequence' => '31'],
            ['code' => 'YCONJ',         'desc' => 'Yellowish conjunctive',                                                              'category' => 'HEENT',    'sequence' => '32'],

            ['code' => 'YELLOWSKIN',    'desc' => 'Yellowish skin',                                                                     'category' => 'SKIN',     'sequence' => '33'],
        ], ['code']);
    }
}
