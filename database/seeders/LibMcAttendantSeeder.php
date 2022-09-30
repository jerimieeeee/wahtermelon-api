<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcAttendant;
use Illuminate\Database\Seeder;

class LibMcAttendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcAttendant::upsert([
            ['code' => 'MD', 'desc' => 'Physician'],
            ['code' => 'MW', 'desc' => 'Midwife'],
            ['code' => 'RN', 'desc' => 'Nurse'],
            ['code' => 'TRH', 'desc' => 'Trained Hilot'],
            ['code' => 'UTH', 'desc' => 'Untrained Hilot'],
            ['code' => 'OTH', 'desc' => 'Other'],
        ], ['desc']);
    }
}
