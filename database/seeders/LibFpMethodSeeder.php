<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpMethod;
use Illuminate\Database\Seeder;

class LibFpMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibFpMethod::upsert([
            ['code' => 'CONDOM',   'desc' => 'Condom',                                             'gender' => 'M', 'fhsis_code' => 'CON',          'sequence' => '11', 'unit' => 'pack'],
            ['code' => 'DMPA',     'desc' => 'Injectables',                                        'gender' => 'F', 'fhsis_code' => 'DMPA',         'sequence' => '5',  'unit' => 'vial'],
            ['code' => 'FSTRBTL',  'desc' => 'Female Sterilization/Bilateral Tubal Ligation',      'gender' => 'F', 'fhsis_code' => 'FSTR/BTL',     'sequence' => '1',  'unit' => null],
            ['code' => 'IMPLANT',  'desc' => 'Implant',                                            'gender' => 'F', 'fhsis_code' => 'IMPLANT',      'sequence' => '12', 'unit' => 'set'],
            ['code' => 'IUD',      'desc' => 'IUD-I',                                              'gender' => 'F', 'fhsis_code' => 'IUD',          'sequence' => '4',  'unit' => 'set'],
            ['code' => 'IUDPP',    'desc' => 'IUD-PP',                                             'gender' => 'F', 'fhsis_code' => 'IUD-PP',       'sequence' => '14', 'unit' => null],
            ['code' => 'MSV',      'desc' => 'Male Sterilization/Vasectomy',                       'gender' => 'M', 'fhsis_code' => 'MSTR/Vasec',   'sequence' => '2',  'unit' => null],
            ['code' => 'NA',       'desc' => 'N/A',                                                'gender' => 'M', 'fhsis_code' => 'N/A',          'sequence' => '0',  'unit' => null],
            ['code' => 'NFPBBT',   'desc' => 'NFP Basal Body Temperature',                         'gender' => 'F', 'fhsis_code' => 'NFP-BBT',      'sequence' => '7',  'unit' => null],
            ['code' => 'NFPCM',    'desc' => 'NFP Cervical Mucus Method',                          'gender' => 'F', 'fhsis_code' => 'NFP-CM',       'sequence' => '6',  'unit' => null],
            ['code' => 'NFPLAM',   'desc' => 'NFP Lactational Amenorrhea',                         'gender' => 'F', 'fhsis_code' => 'NFP-LAM',      'sequence' => '8',  'unit' => null],
            ['code' => 'NFPSDM',   'desc' => 'NFP Standard Days Method',                           'gender' => 'F', 'fhsis_code' => 'NFP-SDM',      'sequence' => '9',  'unit' => null],
            ['code' => 'NFPSTM',   'desc' => 'NFP Sympothermal Method',                            'gender' => 'F', 'fhsis_code' => 'NFP-STM',      'sequence' => '10', 'unit' => null],
            ['code' => 'PILLS',    'desc' => 'Pills-COC',                                          'gender' => 'F', 'fhsis_code' => 'PILLS',        'sequence' => '3',  'unit' => 'set'],
            ['code' => 'PILLSPOP', 'desc' => 'Pills-POP',                                          'gender' => 'F', 'fhsis_code' => 'PILLS-COC',    'sequence' => '13', 'unit' => null],
        ], ['code']);
    }
}
