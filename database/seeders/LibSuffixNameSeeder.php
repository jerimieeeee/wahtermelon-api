<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibSuffixName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibSuffixNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibSuffixName::upsert([
            ['suffix_code' => 'II', 'suffix_desc' => 'II'],
            ['suffix_code' => 'III', 'suffix_desc' => 'III'],
            ['suffix_code' => 'IV', 'suffix_desc' => 'IV'],
            ['suffix_code' => 'JR', 'suffix_desc' => 'Jr.'],
            ['suffix_code' => 'NA', 'suffix_desc' => 'Not Applicable'],
            ['suffix_code' => 'SR', 'suffix_desc' => 'Sr.'],
            ['suffix_code' => 'V', 'suffix_desc' => 'V']
        ], ['suffix_code']);
    }
}
