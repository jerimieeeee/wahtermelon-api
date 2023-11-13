<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Libraries\LibFpDropoutReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibFpDropoutReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibFpDropoutReason::truncate();
        Schema::enableForeignKeyConstraints();

        LibFpDropoutReason::upsert([
            ['code' => 1,    'desc' => 'Pregnant',                                      'fhsis_code' => 'A'],
            ['code' => 2,    'desc' => 'Desire to become pregnant',                     'fhsis_code' => 'B'],
            ['code' => 3,    'desc' => 'Medical complications',                         'fhsis_code' => 'C'],
            ['code' => 4,    'desc' => 'Fear of side effects',                          'fhsis_code' => 'D'],
            ['code' => 5,    'desc' => 'Changed Clinic',                                'fhsis_code' => 'E'],
            ['code' => 6,    'desc' => 'Husband disapproves',                           'fhsis_code' => 'F'],
            ['code' => 7,    'desc' => 'Menopause',                                     'fhsis_code' => 'G'],
            ['code' => 8,    'desc' => 'Lost or moved out of the area or residence',    'fhsis_code' => 'H'],
            ['code' => 9,    'desc' => 'Failed to get supply',                          'fhsis_code' => 'I'],
            ['code' => 10,   'desc' => 'IUD expelled',                                  'fhsis_code' => 'X'],
            ['code' => 11,   'desc' => 'Unknown',                                       'fhsis_code' => 'N'],
            ['code' => 12,   'desc' => 'Changed Method',                                'fhsis_code' => 'J'],
            ['code' => 13,   'desc' => 'Underwent Hysterectomy',                        'fhsis_code' => 'K'],
            ['code' => 14,   'desc' => 'Underwent Bilateral Salpingo-oophorectomy',     'fhsis_code' => 'L'],
            ['code' => 15,   'desc' => 'No FP Commodity',                               'fhsis_code' => 'M'],
            ['code' => 16,   'desc' => 'Age out for BTL',                               'fhsis_code' => 'O'],
        ], ['code']);
    }
}
