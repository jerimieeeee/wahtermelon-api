<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcPresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('lib_mc_presentations')->delete();
        DB::table('lib_mc_presentations')
      ->insert([
      ['presentation_code' => 'CEPH', 'presentation_name' => 'Cephalic'],
      ['presentation_code' => 'BREECH', 'presentation_name' => 'Breech'],
      ['presentation_code' => 'TRANS', 'presentation_name' => 'Transverse'],
      ['presentation_code' => 'MASS', 'presentation_name'=> 'Mass Palpable - NA']
      ]);

    }
}
