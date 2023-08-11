<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEnvironmentalWasteManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEnvironmentalWasteManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEnvironmentalWasteManagement::upsert([
            ['code' => '1',           'desc' => 'Waste Segregation',                                                        'sequence' => '1'],
            ['code' => '2',           'desc' => 'Backyard Composting',                                                      'sequence' => '2'],
            ['code' => '3',           'desc' => 'Recycling/Reuse',                                                          'sequence' => '3'],
            ['code' => '4',           'desc' => 'Collected by City/Municipality Collection and Disposal System',            'sequence' => '4'],
            ['code' => '5',           'desc' => 'Others (Burning / Burying, Specify)',                                      'sequence' => '5'],
        ], ['code']);
    }
}
