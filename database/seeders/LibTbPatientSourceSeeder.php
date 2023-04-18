<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbPatientSource;
use Illuminate\Database\Seeder;

class LibTbPatientSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbPatientSource::upsert([
            ['code' => 'PHC',   'desc' => 'Public Health Center',   'sequence' => 1],
            ['code' => 'PRF',   'desc' => 'Private Facility',       'sequence' => 2],
            ['code' => 'PF',    'desc' => 'Public Facility',        'sequence' => 3],
            ['code' => 'OPF',   'desc' => 'Other Public Facility',  'sequence' => 4],
            ['code' => 'C',     'desc' => 'Community',              'sequence' => 5],
        ], ['code']);
    }
}
