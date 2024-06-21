<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdEyeVisionScreening;
use Illuminate\Database\Seeder;

class LibNcdEyeVisionScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibNcdEyeVisionScreening::upsert([
            ['code' => 'RIGHT',    'desc' => 'Right Eye'],
            ['code' => 'LEFT',     'desc' => 'Left Eye'],
            ['code' => 'BOTH',     'desc' => 'Both Eye'],
            ['code' => 'NONE',     'desc' => 'None'],
        ], ['code']);
    }
}
