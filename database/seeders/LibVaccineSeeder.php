<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibVaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LibVaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibVaccine::truncate();
        Schema::enableForeignKeyConstraints();

        LibVaccine::upsert([
          ['vaccine_id' => 'BCG',     'vaccine_name' => 'BCG Vaccine',                'vaccine_interval' => '1',     'vaccine_module' => 'ccdev',  'vaccine_desc' => 'BCG Vaccine',                           'order_seq' => '1'],
          ['vaccine_id' => 'HEPB',    'vaccine_name' => 'Hepa at Birth',              'vaccine_interval' => '1',     'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepa at Birth',                         'order_seq' => '2'],
          ['vaccine_id' => 'PENTA',   'vaccine_name' => 'Pentavalent',                'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent (5 in 1)',                  'order_seq' => '3'],
          ['vaccine_id' => 'OPV',     'vaccine_name' => 'OPV',                        'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine',               'order_seq' => '4'],
          ['vaccine_id' => 'IPV',     'vaccine_name' => 'IPV',                        'vaccine_interval' => '98',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Inactivated Polio Vaccine',             'order_seq' => '5'],
          ['vaccine_id' => 'PCV',     'vaccine_name' => 'PCV',                        'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pneumococal Conjugate Antigen',         'order_seq' => '6'],
          ['vaccine_id' => 'MCV',     'vaccine_name' => 'MCV',                        'vaccine_interval' => '365',   'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Measles Vaccine',                       'order_seq' => '7'],
          ['vaccine_id' => 'ROTA',   'vaccine_name' => 'Rota',                        'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Rotavirus Vaccine',                     'order_seq' => '8'],
          ['vaccine_id' => 'HEPBV',   'vaccine_name' => 'HEPB',                       'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine',                   'order_seq' => '9'],
          ['vaccine_id' => 'CPV',     'vaccine_name' => 'Varicella Vaccine',          'vaccine_interval' => '1',     'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Varicella (Chickenpox) Vaccine',        'order_seq' => '10'],
          ['vaccine_id' => 'DPT',     'vaccine_name' => 'DPT',                        'vaccine_interval' => '42',    'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine',                           'order_seq' => '11'],
          ['vaccine_id' => 'FLU',     'vaccine_name' => 'Flu Vaccine',                'vaccine_interval' => '1',     'vaccine_module' => 'gen',    'vaccine_desc' => 'Flu Vaccine',                           'order_seq' => '12'],
          ['vaccine_id' => 'HPV',     'vaccine_name' => 'HPV',                        'vaccine_interval' => '1',     'vaccine_module' => 'gen',    'vaccine_desc' => 'Human Papilloma Virus Vaccine',         'order_seq' => '13'],
          ['vaccine_id' => 'HPVGR4',  'vaccine_name' => 'HPV Grade 4',                'vaccine_interval' => '0',     'vaccine_module' => 'gen',    'vaccine_desc' => 'Human Papilloma Virus Vaccine Grade 4', 'order_seq' => '14'],
          ['vaccine_id' => 'IV',      'vaccine_name' => 'Influenza Vaccine',          'vaccine_interval' => '0',     'vaccine_module' => 'ncd',    'vaccine_desc' => 'Influenza Vaccine',                     'order_seq' => '15'],
          ['vaccine_id' => 'MRGR',    'vaccine_name' => 'MR GRADE 1',                 'vaccine_interval' => '0',     'vaccine_module' => 'gen',    'vaccine_desc' => 'Measles Rubella Grade 1',               'order_seq' => '16'],
          ['vaccine_id' => 'MRGR7',   'vaccine_name' => 'MR Grade 7',                 'vaccine_interval' => '0',     'vaccine_module' => 'gen',    'vaccine_desc' => 'Measles Rubella Grade 7',               'order_seq' => '17'],

          ['vaccine_id' => 'PCECV1',  'vaccine_name' => 'Safety and Immunogenicity of Purified Chick Embryo', 'vaccine_interval' => '0', 'vaccine_module' => 'animalbite',  'vaccine_desc' => 'Vaxirab-N',    'order_seq' => '18'],

          ['vaccine_id' => 'PPV',     'vaccine_name' => 'PPV',                            'vaccine_interval' => '0',  'vaccine_module' =>  'ncd',  'vaccine_desc' =>   'Pneumococcal Polysccharide Vaccine',  'order_seq' => '19'],

          ['vaccine_id' => 'PVRV1',   'vaccine_name' => 'Immunogenicity, Safety and Antibody Persistence of', 'vaccine_interval' => '0',   'vaccine_module' =>  'animalbite',  'vaccine_desc' => 'Speeda',                    'order_seq' => '20'],
          ['vaccine_id' => 'PVRV2',   'vaccine_name' => 'Purified Vero Cell Culture Rabies Vaccine',          'vaccine_interval' => '0',   'vaccine_module' =>  'animalbite',  'vaccine_desc' => 'Abhayrab',                  'order_seq' => '21'],
          ['vaccine_id' => 'PVRV3',   'vaccine_name' => 'Verorab',                                            'vaccine_interval' => '0',   'vaccine_module' =>  'animalbite',  'vaccine_desc' => 'Verorab',                   'order_seq' => '22'],
          ['vaccine_id' => 'PVRV4',   'vaccine_name' => 'Indirab',                                            'vaccine_interval' => '0',   'vaccine_module' =>  'animalbite',  'vaccine_desc' => 'Indirab',                   'order_seq' => '23'],
          ['vaccine_id' => 'TDGR1',   'vaccine_name' => 'TD Grade 1',                                         'vaccine_interval' => '0',   'vaccine_module' =>  'gen',         'vaccine_desc' => 'Tetanus Diptheria Grade 1', 'order_seq' => '24'],
          ['vaccine_id' => 'TDGR7',   'vaccine_name' => 'TD Grade 7',                                         'vaccine_interval' => '0',   'vaccine_module' =>  'gen',         'vaccine_desc' => 'Tetanus Diptheria Grade 7', 'order_seq' => '25'],
          ['vaccine_id' => 'TD',     'vaccine_name' => 'TD Vaccine',                                          'vaccine_interval' => '0',   'vaccine_module' => 'mc',           'vaccine_desc' => 'Tetanus Diptheria',         'order_seq' => '26'],
          ['vaccine_id' => 'TT',     'vaccine_name' => 'TT Vaccine',                                          'vaccine_interval' => '0',   'vaccine_module' => 'gen',          'vaccine_desc' => 'Tetanus Toxoid',            'order_seq' => '27'],
          ['vaccine_id' => 'PCECV2',  'vaccine_name' => 'Inactivated Rabies Virus Vaccine',                   'vaccine_interval' => '0', 'vaccine_module' => 'animalbite',     'vaccine_desc' => 'Rabipur',                   'order_seq' => '28'],

        //   ['vaccine_id' => 'DPT1',    'vaccine_name' => 'DPT1',                           'vaccine_interval' => '42', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine 1st Dose'],
        //   ['vaccine_id' => 'DPT2',    'vaccine_name' => 'DPT2',                           'vaccine_interval' => '70', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine 2nd Dose'],
        //   ['vaccine_id' => 'DPT3',    'vaccine_name' => 'DPT3',                           'vaccine_interval' => '98', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine 3rd Dose'],
        //   ['vaccine_id' => 'HEPB1',   'vaccine_name' => 'HB1',                            'vaccine_interval' => '42', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine 1st Dose'],
        //   ['vaccine_id' => 'HEPB2',   'vaccine_name' => 'HB2',                            'vaccine_interval' => '70', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine 2nd Dose'],
        //   ['vaccine_id' => 'HEPB3',   'vaccine_name' => 'HB3',                            'vaccine_interval' => '98', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine 3rd Dose'],
        //   ['vaccine_id' => 'MCV1',    'vaccine_name' => 'MCV1',                           'vaccine_interval' => '365','vaccine_module' => 'ccdev',  'vaccine_desc' => 'Measles Vaccine'],
        //   ['vaccine_id' => 'MCV2',    'vaccine_name' => 'MCV2',                           'vaccine_interval' => '365','vaccine_module' => 'ccdev',  'vaccine_desc' => 'Measles, Mumps, Rubella Vaccine'],
        //   ['vaccine_id' => 'MRGR1',   'vaccine_name' => 'MR Grade 1',                     'vaccine_interval' => '0',  'vaccine_module' => 'gen',    'vaccine_desc' => 'Measles Rubella Grade 1'],
        //   ['vaccine_id' => 'OPV1',    'vaccine_name' => 'OPV 1',                          'vaccine_interval' => '42', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine 1st'],
        //   ['vaccine_id' => 'OPV2',    'vaccine_name' => 'OPV 2',                          'vaccine_interval' => '70', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine 2nd'],
        //   ['vaccine_id' => 'OPV3',    'vaccine_name' => 'OPV 3',                          'vaccine_interval' => '98', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine 3rd'],
        //   ['vaccine_id' => 'PCV1',    'vaccine_name' => 'PCV 1',                          'vaccine_interval' => '42', 'vaccine_module' => 'ccdev',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 1st dose'],
        //   ['vaccine_id' => 'PCV2',    'vaccine_name' => 'PCV 2',                          'vaccine_interval' => '70', 'vaccine_module' => 'ccdev',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 2nd dose'],
        //   ['vaccine_id' => 'PCV3',    'vaccine_name' => 'PCV 3',                          'vaccine_interval' => '98', 'vaccine_module' => 'ccdev',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 3rd dose'],
        //   ['vaccine_id' => 'PENTA1',  'vaccine_name' => 'Pentavalent 1',                  'vaccine_interval' => '42', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 1 (5 in 1) 1st Dose'],
        //   ['vaccine_id' => 'PENTA2',  'vaccine_name' => 'Pentavalent 2',                  'vaccine_interval' => '70', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 2 (5 in 1) 2nd Dose'],
        //   ['vaccine_id' => 'PENTA3',  'vaccine_name' => 'Pentavalent 3',                  'vaccine_interval' => '98', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 3 (5 in 1) 3rd Dose'],
        //   ['vaccine_id' => 'ROTA1',   'vaccine_name' => 'Rota 1',                       'vaccine_interval' => '42',  'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Rotavirus Vaccine 1st Dose'],
        //   ['vaccine_id' => 'ROTA2',   'vaccine_name' => 'Rota 2',                       'vaccine_interval' => '70',  'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Rotavirus Vaccine 2nd Dose'],
        //   ['vaccine_id' => 'ROTA3',   'vaccine_name' =>  'Rota 3',                      'vaccine_interval' => '98',  'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Rotavirus Vaccine 3rd Dose'],
        //   ['vaccine_id' => 'TT',     'vaccine_name' => 'TT1 Vaccine',                  'vaccine_interval' => '0',   'vaccine_module' => 'gen',     'vaccine_desc' => 'Tetanus Toxoid 1', 'order_seq' => '27'],
        //   ['vaccine_id' => 'TT2',     'vaccine_name' => 'TT2 Vaccine',                  'vaccine_interval' => '0',   'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 2'],
        //   ['vaccine_id' => 'TT3',     'vaccine_name' => 'TT3 Vaccine',                  'vaccine_interval' => '0',   'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 3'],
        //   ['vaccine_id' => 'TT4',     'vaccine_name' => 'TT4 Vaccine',                  'vaccine_interval' => '0',   'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 4'],
        //   ['vaccine_id' => 'TT5',     'vaccine_name' => 'TT5 Vaccine',                  'vaccine_interval' => '0',   'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 5']
        ], ['vaccine_id']);
    }
}
