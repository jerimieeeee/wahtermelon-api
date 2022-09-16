<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcAttendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('lib_mc_attendants')->delete();
        DB::table('lib_mc_attendants')
      ->insert([
      ['attendant_code' => 'MD' , 'attendant_name' => 'Physician'],
      ['attendant_code' => 'MW' , 'attendant_name' => 'Midwife'],
      ['attendant_code' => 'RN' , 'attendant_name' => 'Nurse'],
      ['attendant_code' => 'TRH', 'attendant_name' => 'Trained Hilot'],
      ['attendant_code' => 'UTH', 'attendant_name' => 'Untrained Hilot'],
      ['attendant_code' => 'OTH', 'attendant_name' => 'Other']
    ]);

    }
    }
