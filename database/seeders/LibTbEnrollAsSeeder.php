<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbEnrollAs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbEnrollAsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbEnrollAs::upsert([
            ['code' => 'IPT',   'desc' => 'IPT Case'],
            ['code' => 'DSTB',  'desc' => 'DS-TB Case']
        ], ['code']);
    }
}
