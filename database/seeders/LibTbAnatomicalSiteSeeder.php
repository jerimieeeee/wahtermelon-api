<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbAnatomicalSite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbAnatomicalSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbAnatomicalSite::upsert([
            ['code' => 'P', 'desc' => 'Pulmonary'],
            ['code' => 'EP', 'desc' => 'Extra-pulmonary']
        ], ['code']);
    }
}
