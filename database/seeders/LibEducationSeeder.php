<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEducation;
use Illuminate\Database\Seeder;

class LibEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibEducation::upsert([
            ['code' => 1,   'education_desc' => 'Elementary Graduate',                   'sequence' => '4'],
            ['code' => 2,   'education_desc' => 'High School Graduate',                  'sequence' => '7'],
            ['code' => 3,   'education_desc' => 'College Graduate',                      'sequence' => '11'],
            ['code' => 4,   'education_desc' => 'Postgraduate/ Masteral/ Doctorate',     'sequence' => '13'],
            ['code' => 5,   'education_desc' => 'No Formal Education - No Schooling',    'sequence' => '15'],
            ['code' => 6,   'education_desc' => 'Not Applicable',                        'sequence' => '16'],
            ['code' => 7,   'education_desc' => 'Vocational Course',                     'sequence' => '14'],
            ['code' => 8,   'education_desc' => 'Others',                                'sequence' => '17'],
            ['code' => 9,   'education_desc' => 'Pre-school',                            'sequence' => '1'],
            ['code' => 10,  'education_desc' => 'Elementary Undergraduate',              'sequence' => '2'],
            ['code' => 11,  'education_desc' => 'Elementary Student',                    'sequence' => '3'],
            ['code' => 12,  'education_desc' => 'High School Undergraduate',             'sequence' => '5'],
            ['code' => 13,  'education_desc' => 'High School Student',                   'sequence' => '6'],
            ['code' => 14,  'education_desc' => 'Senior High School',                    'sequence' => '8'],
            ['code' => 15,  'education_desc' => 'ALS - Advance Learning System',         'sequence' => '9'],
            ['code' => 16,  'education_desc' => 'College Undergraduate',                 'sequence' => '10'],
            ['code' => 17,  'education_desc' => 'College Student',                       'sequence' => '12'],
        ], ['education_desc']);
    }
}
