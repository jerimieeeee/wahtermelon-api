<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LibVaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lib_vaccines')->delete();
        DB::table('lib_vaccines')
        ->insert([
          ['vaccine_id' => 'BCG',     'vaccine_name' => 'BCG Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'BCG Vaccine'],
          ['vaccine_id' => 'CPV',     'vaccine_name' => 'Varicella Vaccine',              'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Varicella (Chickenpox) Vaccine'],
          ['vaccine_id' => 'DPT1',    'vaccine_name' => 'DPT1 Vaccine',                   'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine'],
          ['vaccine_id' => 'DPT2',    'vaccine_name' => 'DPT2 Vaccine',                   'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine'],
          ['vaccine_id' => 'DPT3',    'vaccine_name' => 'DPT3 Vaccine',                   'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'DPT Vaccine'],
          ['vaccine_id' => 'HEPB',    'vaccine_name' => 'Hepa at Birth',                  'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepa at Birth'],
          ['vaccine_id' => 'FLU',     'vaccine_name' => 'Flu Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Flue Vaccine'],
          ['vaccine_id' => 'HEPB1',   'vaccine_name' => 'Hepatitis B1 Vaccine',           'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine'],
          ['vaccine_id' => 'HEPB2',   'vaccine_name' => 'Hepatitis B2 Vaccine',           'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine'],
          ['vaccine_id' => 'HEPB3',   'vaccine_name' => 'Hepatitis B3 Vaccine',           'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Hepatitis B Vaccine'],
          ['vaccine_id' => 'HPV',     'vaccine_name' => 'HPV Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Human Papilloma Virus Vaccine'],
          ['vaccine_id' => 'MMR',     'vaccine_name' => 'Measles, Mumps, Rubella (MMR)',  'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Measles, Mumps, Rubella (MMR)'],
          ['vaccine_id' => 'IPV',     'vaccine_name' => 'IPV Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Inactivated Polio Vaccine'],
          ['vaccine_id' => 'MSL',     'vaccine_name' => 'Measles Vaccine',                'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Measles Vaccine'],
          ['vaccine_id' => 'OPV1',    'vaccine_name' => 'OPV 1',                          'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine'],
          ['vaccine_id' => 'OPV2',    'vaccine_name' => 'OPV 2',                          'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine'],
          ['vaccine_id' => 'OPV3',    'vaccine_name' => 'OPV 3',                          'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Oral Poliovirus Vaccine'],
          ['vaccine_id' => 'PCV1',    'vaccine_name' => 'PCV 1',                          'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 1st dose'],
          ['vaccine_id' => 'PCV2',    'vaccine_name' => 'PCV 2',                          'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 2nd dose'],
          ['vaccine_id' => 'PCV3',    'vaccine_name' => 'PCV 3',                          'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Pneumococal Conjugate Antigen 3rd dose'],
          ['vaccine_id' => 'PENTA1',  'vaccine_name' => 'Pentavalent 1',                  'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 1 (5 in 1)'],
          ['vaccine_id' => 'PENTA2',  'vaccine_name' => 'Pentavalent 2',                  'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 2 (5 in 1)'],
          ['vaccine_id' => 'PENTA3',  'vaccine_name' => 'Pentavalent 3',                  'vaccine_interval' => '', 'vaccine_module' => 'ccdev',  'vaccine_desc' => 'Pentavalent 3 (5 in 1)'],
          ['vaccine_id' => 'ROTA',    'vaccine_name' => 'Rotavirus Vaccine 1',            'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Rotavirus Vaccine 1'],
          ['vaccine_id' => 'ROTA2',   'vaccine_name' => 'Rotavirus Vaccine 2',            'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Rotavirus Vaccine 2'],
          ['vaccine_id' => 'ROTA3',   'vaccine_name' => 'Rotavirus Vaccine 3',            'vaccine_interval' => '', 'vaccine_module' => '',       'vaccine_desc' => 'Rotavirus Vaccine 3'],
          ['vaccine_id' => 'TT1',     'vaccine_name' => 'TT1 Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 1'],
          ['vaccine_id' => 'TT2',     'vaccine_name' => 'TT2 Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 2'],
          ['vaccine_id' => 'TT3',     'vaccine_name' => 'TT3 Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 3'],
          ['vaccine_id' => 'TT4',     'vaccine_name' => 'TT4 Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 4'],
          ['vaccine_id' => 'TT5',     'vaccine_name' => 'TT5 Vaccine',                    'vaccine_interval' => '', 'vaccine_module' => 'mc',     'vaccine_desc' => 'Tetanus Toxoid 5']
        ]);
    }
}
