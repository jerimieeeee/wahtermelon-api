<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpSourceSupply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibFpSourceSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFpSourceSupply::upsert([
            ['code' => '1',         'desc' => 'MLGU',                        'category' => 'F'],
            ['code' => '2',         'desc' => 'PLGU',                        'category' => 'F'],
            ['code' => '3',         'desc' => 'DOH',                         'category' => 'F'],
            ['code' => '4',         'desc' => 'NGO',                         'category' => 'F'],
            ['code' => '5',         'desc' => 'N/A',                         'category' => 'NA'],
            ['code' => '6',         'desc' => 'Bought at own expense',       'category' => 'B'],
        ], ['code']);
    }
}
