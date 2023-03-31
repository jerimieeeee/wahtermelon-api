<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbBacteriologicalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbBacteriologicalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbBacteriologicalStatus::upsert([
            ['code' => 'BC', 'desc' => 'Bacteriologically-confirmed (DSTB)'],
            ['code' => 'CD', 'desc' => 'Clinically-diagnosed (DSTB)']
        ], ['code']);
    }
}
