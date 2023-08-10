<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbVaccineRoute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbVaccineRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbVaccineRoute::upsert([
            ['code' => 'ID', 'desc' => 'INTRADERMAL', 'sequence' => 1],
            ['code' => 'IM', 'desc' => 'INTRAMUSCULAR', 'sequence' => 2]
        ], ['code']);
    }
}
