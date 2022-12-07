<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcDeliveryLocation;
use Illuminate\Database\Seeder;

class LibMcDeliveryLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcDeliveryLocation::upsert([
            ['code' => 'HOME', 'desc' => 'Home'],
            ['codeid' => 'HOSP', 'desc' => 'Public Hospital'],
            ['code' => 'HOSPP', 'desc' => 'Private Hospital'],
            ['code' => 'LYINP', 'desc' => 'Public Lying-In Clinic'],
            ['code' => 'LYIN', 'desc' => 'Private Lying-In Clinic'],
            ['code' => 'HC', 'desc' => 'Health Center'],
            ['code' => 'BHS', 'desc' => 'Barangay Health Station'],
            ['code' => 'DOHAM', 'desc' => 'DOH-Licensed Ambulance'],
            ['code' => 'OTHERS', 'desc' => 'Others'],
        ], ['desc']);
    }
}
