<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbAnimalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbAnimalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbAnimalStatus::upsert([
            ['code' => 'AL',     'desc' => 'ALIVE', 'sequence' => 1],
            ['code' => 'DDTR',   'desc' => 'DEAD DUE TO RABIES', 'sequence' => 2],
            ['code' => 'DDUR',   'desc' => 'DEAD DUE TO UNKNOWN REASONS', 'sequence' => 3],
            ['code' => 'KILLED', 'desc' => 'KILLED', 'sequence' => 4],
            ['code' => 'SICK',   'desc' => 'SICK', 'sequence' => 5],
            ['code' => 'US',     'desc' => 'UNKNOWN/STRAY', 'sequence' => 6]
        ], ['code']);
    }
}
