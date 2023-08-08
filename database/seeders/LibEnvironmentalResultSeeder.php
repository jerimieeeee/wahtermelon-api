<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEnvironmentalResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEnvironmentalResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEnvironmentalResult::upsert([
            ['code' => 'POSITIVE',           'desc' => 'Positive'],
            ['code' => 'NEGATIVE',           'desc' => 'Negative'],
        ], ['code']);
    }
}
