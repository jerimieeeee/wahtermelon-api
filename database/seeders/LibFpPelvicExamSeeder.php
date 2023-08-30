<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpPelvicExam;
use Illuminate\Database\Seeder;

class LibFpPelvicExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFpPelvicExam::upsert([
            ['code' => '1',       'desc' => 'Scars',                                              'category' => 'PERINEUM',              'sequence' => '1'],
            ['code' => '2',       'desc' => 'Warts',                                              'category' => 'PERINEUM',              'sequence' => '2'],
            ['code' => '3',       'desc' => 'Reddish',                                            'category' => 'PERINEUM',              'sequence' => '3'],
            ['code' => '4',       'desc' => 'Laceration',                                         'category' => 'PERINEUM',              'sequence' => '4'],
            ['code' => '5',       'desc' => 'Congested',                                          'category' => 'VAGINA',                'sequence' => '5'],
            ['code' => '6',       'desc' => 'Bartholin\'s Cyst',                                  'category' => 'VAGINA',                'sequence' => '6'],
            ['code' => '7',       'desc' => 'Warts',                                              'category' => 'VAGINA',                'sequence' => '7'],
            ['code' => '8',       'desc' => 'Skene\'s Gland Discharge',                           'category' => 'VAGINA',                'sequence' => '8'],
            ['code' => '9',       'desc' => 'Rectocele',                                          'category' => 'VAGINA',                'sequence' => '9'],
            ['code' => '10',      'desc' => 'Cystocele',                                          'category' => 'VAGINA',                'sequence' => '10'],
            ['code' => '11',      'desc' => 'Congested',                                          'category' => 'CERVIX',                'sequence' => '11'],
            ['code' => '12',      'desc' => 'Erosion',                                            'category' => 'CERVIX',                'sequence' => '12'],
            ['code' => '13',      'desc' => 'Discharge',                                          'category' => 'CERVIX',                'sequence' => '13'],
            ['code' => '14',      'desc' => 'Polyps/Cyst',                                        'category' => 'CERVIX',                'sequence' => '14'],
            ['code' => '15',      'desc' => 'Laceration',                                         'category' => 'CERVIX',                'sequence' => '15'],
            ['code' => '16',      'desc' => 'Pinkish',                                            'category' => 'CERVIX COLOR',          'sequence' => '16'],
            ['code' => '17',      'desc' => 'Bluish',                                             'category' => 'CERVIX COLOR',          'sequence' => '17'],
            ['code' => '19',      'desc' => 'Firm',                                               'category' => 'CERVIX CONSISTENCY',    'sequence' => '18'],
            ['code' => '20',      'desc' => 'Soft',                                               'category' => 'CERVIX CONSISTENCY',    'sequence' => '19'],
            ['code' => '21',      'desc' => 'Mid',                                                'category' => 'UTERUS POSITION',       'sequence' => '20'],
            ['code' => '22',      'desc' => 'Anteflexed',                                         'category' => 'UTERUS POSITION',       'sequence' => '21'],
            ['code' => '23',      'desc' => 'Retroflexed',                                        'category' => 'UTERUS POSITION',       'sequence' => '22'],
            ['code' => '24',      'desc' => 'Normal',                                             'category' => 'UTERUS SIZE',           'sequence' => '23'],
            ['code' => '25',      'desc' => 'Small',                                              'category' => 'UTERUS SIZE',           'sequence' => '24'],
            ['code' => '26',      'desc' => 'Large',                                              'category' => 'UTERUS SIZE',           'sequence' => '25'],
            ['code' => '27',      'desc' => 'Normal',                                             'category' => 'ADNEXA',                'sequence' => '26'],
            ['code' => '28',      'desc' => 'Mass',                                               'category' => 'ADNEXA',                'sequence' => '27'],
            ['code' => '29',      'desc' => 'Tenderness',                                         'category' => 'ADNEXA',                'sequence' => '28'],
        ], ['code']);
    }
}
