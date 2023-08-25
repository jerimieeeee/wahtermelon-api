<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbAnatomicalLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbAnatomicalLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbAnatomicalLocation::upsert([
            ['id' => 1, 'desc' => 'Arms', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Feet', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Hand', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Head', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Knee', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Leg', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Neck', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Others', 'sequence' => 8]
        ], ['id']);
    }
}
