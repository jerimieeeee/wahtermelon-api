<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpDropoutReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibFpDropoutReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFpDropoutReason::upsert([
            ['desc' => 'Pregnant',                                      'fhsis_code' => 'A'],
            ['desc' => 'Desire to become pregnant',                     'fhsis_code' => 'B'],
            ['desc' => 'Medical complications',                         'fhsis_code' => 'C'],
            ['desc' => 'Fear of side effects',                          'fhsis_code' => 'D'],
            ['desc' => 'Changed clinic',                                'fhsis_code' => 'E'],
            ['desc' => 'Husband disapproves',                           'fhsis_code' => 'F'],
            ['desc' => 'Menopause',                                     'fhsis_code' => 'G'],
            ['desc' => 'Lost or moved out of the area or residence',    'fhsis_code' => 'H'],
            ['desc' => 'Failed to get supply',                          'fhsis_code' => 'I'],
            ['desc' => 'IUD expelled',                                  'fhsis_code' => 'J'],
            ['desc' => 'Unknown',                                       'fhsis_code' => 'K'],
            ['desc' => 'Changing Method',                               'fhsis_code' => 'Y'],
        ], ['code']);
    }
}
