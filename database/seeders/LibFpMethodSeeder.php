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
            ['id' => 'CONDOM',   'method_desc' => 'Condom',                                             'method_gender' => 'M', 'fhsis_code' => 'CON',          'report_order' => '11', 'unit' => 'pack'],
            ['id' => 'DMPA',     'method_desc' => 'Injectables',                                        'method_gender' => 'F', 'fhsis_code' => 'DMPA',         'report_order' => '5',  'unit' => 'vial'],
            ['id' => 'FSTRBTL',  'method_desc' => 'Female Sterilization /Bilateral Tubal Ligation',     'method_gender' => 'F', 'fhsis_code' => 'FSTR/BTL',     'report_order' => '1',  'unit' => null],
            ['id' => 'IMPLANT',  'method_desc' => 'Implant',                                            'method_gender' => 'F', 'fhsis_code' => 'IMPLANT',      'report_order' => '12', 'unit' => 'set'],
            ['id' => 'IUD',      'method_desc' => 'IUD-I',                                              'method_gender' => 'F', 'fhsis_code' => 'IUD',          'report_order' => '4',  'unit' => 'set'],
            ['id' => 'IUDPP',    'method_desc' => 'IUD-PP',                                             'method_gender' => 'F', 'fhsis_code' => 'IUD-PP',       'report_order' => '14', 'unit' => null],
            ['id' => 'MSV',      'method_desc' => 'Male Sterilization /Vasectomy',                      'method_gender' => 'M', 'fhsis_code' => 'MSTR/Vasec',   'report_order' => '2',  'unit' => null],
            ['id' => 'NA',       'method_desc' => 'N/A',                                                'method_gender' => 'M', 'fhsis_code' => 'N/A',          'report_order' => '0',  'unit' => null],
            ['id' => 'NFPBBT',   'method_desc' => 'NFP Basal Body Temperature',                         'method_gender' => 'F', 'fhsis_code' => 'NFP-BBT',      'report_order' => '7',  'unit' => null],
            ['id' => 'NFPCM',    'method_desc' => 'NFP Cervical Mucus Method',                          'method_gender' => 'F', 'fhsis_code' => 'NFP-CM',       'report_order' => '6',  'unit' => null],
            ['id' => 'NFPLAM',   'method_desc' => 'NFP Lactational amenorrhea',                         'method_gender' => 'F', 'fhsis_code' => 'NFP-LAM',      'report_order' => '8',  'unit' => null],
            ['id' => 'NFPSDM',   'method_desc' => 'NFP Standard Days Method',                           'method_gender' => 'F', 'fhsis_code' => 'NFP-SDM',      'report_order' => '9',  'unit' => null],
            ['id' => 'NFPSTM',   'method_desc' => 'NFP Sympothermal Method',                            'method_gender' => 'F', 'fhsis_code' => 'NFP-STM',      'report_order' => '10', 'unit' => null],
            ['id' => 'PILLS',    'method_desc' => 'Pills-COC',                                          'method_gender' => 'F', 'fhsis_code' => 'PILLS',        'report_order' => '3',  'unit' => 'set'],
            ['id' => 'PILLSPOP', 'method_desc' => 'Pills-POP',                                          'method_gender' => 'F', 'fhsis_code' => 'PILLS-COC',    'report_order' => '13', 'unit' => null],
        ], ['id']);
    }
}
