<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbVaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbVaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbVaccine::upsert([
            ['code' => 'PCECV1', 'desc' => 'Vaxirab-N', 'sequence' => 1],
            ['code' => 'PCECV2', 'desc' => 'Rabipur',   'sequence' => 2],
            ['code' => 'PVRV1',  'desc' => 'Speeda',    'sequence' => 3],
            ['code' => 'PVRV2',  'desc' => 'Abhayrab',  'sequence' => 4],
            ['code' => 'PVRV3',  'desc' => 'Verorab',   'sequence' => 5],
            ['code' => 'PVRV4',  'desc' => 'Indirab',   'sequence' => 6],
            ['code' => 'PVRV5',  'desc' => 'ChiroRab',  'sequence' => 7],
        ], ['code']);
    }
}
