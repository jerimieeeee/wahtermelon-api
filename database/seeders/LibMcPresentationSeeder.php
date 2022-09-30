<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcPresentation;
use Illuminate\Database\Seeder;

class LibMcPresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcPresentation::upsert([
            ['code' => 'CEPH', 'desc' => 'Cephalic'],
            ['code' => 'BREECH', 'desc' => 'Breech'],
            ['code' => 'TRANS', 'desc' => 'Transverse'],
            ['code' => 'MASS', 'desc'=> 'Mass Palpable - NA']
        ], ['desc']);
    }
}
