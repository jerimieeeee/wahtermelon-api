<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use Illuminate\Database\Seeder;

class LibTbTreatmentOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbTreatmentOutcome::upsert([
            ['code' => 'C',     'desc' => 'Cured',                  'sequence' => 1],
            ['code' => 'E',     'desc' => 'Excluded',               'sequence' => 2],
            ['code' => 'F',     'desc' => 'Failed',                 'sequence' => 3],
            ['code' => 'LTFU',  'desc' => 'Lost to Follow-up',      'sequence' => 4],
            ['code' => 'NE',    'desc' => 'Not Enrolled',           'sequence' => 5],
            ['code' => 'NET',   'desc' => 'Not Evaluated',          'sequence' => 6],
            ['code' => 'OT',    'desc' => 'On Treatment',           'sequence' => 7],
            ['code' => 'TR',    'desc' => 'Treatment Completed',    'sequence' => 8],
            ['code' => 'D',     'desc' => 'Died',                   'sequence' => 9],
        ], ['code']);
    }
}
