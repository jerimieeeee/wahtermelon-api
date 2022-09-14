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
            ['code' => 'II', 'suffix_desc' => 'II'],
            ['code' => 'III', 'suffix_desc' => 'III'],
            ['code' => 'IV', 'suffix_desc' => 'IV'],
            ['code' => 'JR', 'suffix_desc' => 'Jr.'],
            ['code' => 'NA', 'suffix_desc' => 'Not Applicable'],
            ['code' => 'SR', 'suffix_desc' => 'Sr.'],
            ['code' => 'V', 'suffix_desc' => 'V']
        ], ['code']);
    }
}
