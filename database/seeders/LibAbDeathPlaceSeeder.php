<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbDeathPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbDeathPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbDeathPlace::upsert([
            ['id' => 1, 'desc' => 'Facility Based', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Non-facility Based', 'sequence' => 2],
        ], ['id']);
    }
}
