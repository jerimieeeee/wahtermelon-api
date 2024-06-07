<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDentalOralCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDentalOralConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDentalOralCondition::upsert([
            ['id' => 1,  'desc' => 'Healthy Gums',                                      'column_name' => 'healthy_gums_flag',       'sequence' => 1],
            ['id' => 2,  'desc' => 'Orally Fit',                                        'column_name' => 'orally_fit_flag',         'sequence' => 2],
            ['id' => 3,  'desc' => 'Oral Health Rehabilitation',                        'column_name' => 'oral_rehab_flag',         'sequence' => 3],
            ['id' => 4,  'desc' => 'Dental Caries',                                     'column_name' => 'dental_caries_flag',      'sequence' => 4],
            ['id' => 5,  'desc' => 'Gingivitis',                                        'column_name' => 'gingivitis_flag',         'sequence' => 5],
            ['id' => 6,  'desc' => 'Periodontal Disease',                               'column_name' => 'periodontal_flag',        'sequence' => 6],
            ['id' => 7,  'desc' => 'Debris',                                            'column_name' => 'debris_flag',             'sequence' => 7],
            ['id' => 8,  'desc' => 'Calculus',                                          'column_name' => 'calculus_flag',           'sequence' => 8],
            ['id' => 9,  'desc' => 'Abnormal Growth',                                   'column_name' => 'abnormal_growth_flag',    'sequence' => 9],
            ['id' => 10, 'desc' => 'Cleft Lip/Palate',                                  'column_name' => 'cleft_lip_flag',          'sequence' => 10],
            ['id' => 11, 'desc' => 'Supernumerary/Mesiodens etc',                       'column_name' => 'supernumerary_flag',      'sequence' => 11],
            ['id' => 12, 'desc' => 'Dento-facial Anomaly that limits normal function',  'column_name' => 'dento_facial_flag',       'sequence' => 12],
            ['id' => 13, 'desc' => 'Others',                                            'column_name' => 'others_flag',             'sequence' => 13]
        ], ['id']);
    }
}
