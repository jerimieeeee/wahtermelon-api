<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbRiskFactor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbRiskFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbRiskFactor::upsert([
            ['code' => 'C', 'desc' => 'Contact of a confirmed/suspected DRTB case', 'sequence' => 1],
            ['code' => 'H', 'desc' => 'PLHIV with signs and symptoms suggestive of TB', 'sequence' => 2],
            ['code' => 'NC', 'desc' => 'Non-converter of Category I or Category II treatment', 'sequence' => 3],
        ], ['code']);
    }
}
