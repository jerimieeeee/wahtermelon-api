<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcDelLocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lib_mc_del_locs')->delete();
        DB::table('lib_mc_del_locs')
      ->insert([
      ['del_loc_code' => 'HOME', 'del_loc_name' => 'Home'],
      ['del_loc_codeid' => 'HOSP', 'del_loc_name' => 'Public Hospital'],
      ['del_loc_code' => 'HOSPP', 'del_loc_name' => 'Private Hospital'],
      ['del_loc_code' => 'LYINP', 'del_loc_name' => 'Public Lying-In Clinic'],
      ['del_loc_code' => 'LYIN', 'del_loc_name' => 'Private Lying-In Clinic'],
      ['del_loc_code' => 'HC', 'del_loc_name' => 'Health Center'],
      ['del_loc_code' => 'BHS', 'del_loc_name' => 'Barangay Health Station'],
      ['del_loc_code' => 'DOHAM', 'del_loc_name' => 'DOH-Licensed Ambulance'],
      ['del_loc_code' => 'OTHERS', 'del_loc_name' => 'Others']
        ]);
    }
}
