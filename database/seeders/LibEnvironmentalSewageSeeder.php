<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEnvironmentalSewage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEnvironmentalSewageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEnvironmentalSewage::upsert([
            ['code' => '1',           'desc' => 'Sewage/excreta is safely disposed in situ',                                         'sequence' => '1'],
            ['code' => '2',           'desc' => 'Sewage/excreta is collected, transported and disposed off site',                    'sequence' => '2'],
        ], ['code']);
    }
}
